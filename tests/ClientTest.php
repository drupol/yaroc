<?php

declare(strict_types=1);

namespace drupol\Yaroc\Tests;

use drupol\Yaroc\ApiMethods;
use drupol\Yaroc\Client;
use drupol\Yaroc\ClientInterface;
use drupol\Yaroc\Exception;
use Error;
use GuzzleHttp\Client as HttpClient;
use Http\Client\Common\PluginClient;
use Http\Client\Plugin\Vcr\NamingStrategy\NamingStrategyInterface;
use Http\Client\Plugin\Vcr\NamingStrategy\PathNamingStrategy;
use Http\Client\Plugin\Vcr\Recorder\FilesystemRecorder;
use Http\Client\Plugin\Vcr\RecordPlugin;
use Http\Client\Plugin\Vcr\ReplayPlugin;
use loophp\psr17\Psr17;
use loophp\psr17\Psr17Interface;
use Nyholm\Psr7\Factory\Psr17Factory;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface as HttpClientInterface;
use Psr\Http\Message\RequestInterface;

use const JSON_THROW_ON_ERROR;

/**
 * @covers \drupol\Yaroc\Client
 * @covers \drupol\Yaroc\Errors
 * @covers \drupol\Yaroc\Exception::invalidRequest
 * @covers \drupol\Yaroc\Exception::invalidStatusCode
 * @covers \drupol\Yaroc\Exception::jsonRpcError
 * @covers \drupol\Yaroc\Exception::unableToDecodeJson
 * @covers \drupol\Yaroc\Exception::unableToExtractResult
 * @covers \drupol\Yaroc\Exception::unableToSendRequest
 *
 * @internal
 */
final class ClientTest extends TestCase
{
    public function testCall(): void
    {
        $result = $this
            ->makeClient()
            ->call(
                ApiMethods::GenerateIntegers,
                [
                    'n' => 10,
                    'min' => 1,
                    'max' => 100,
                ]
            );

        self::assertEquals('{"jsonrpc":"2.0","result":{"random":{"data":[60,7,21,99,97,88,53,5,70,41],"completionTime":"2023-07-22 11:23:14Z"},"bitsUsed":66,"bitsLeft":249802,"requestsLeft":997,"advisoryDelay":2290},"id":"generateIntegers_64bbbc22842dc8.38709527"}', (string) $result->getBody());
    }

    public function testConstructor()
    {
        self::assertInstanceOf(ClientInterface::class, $this->makeClient());
    }

    public function testGet(): void
    {
        $result = $this
            ->makeClient()
            ->get(
                ApiMethods::GenerateIntegers,
                [
                    'n' => 10,
                    'min' => 1,
                    'max' => 100,
                ]
            );

        self::assertEquals(json_decode('{"jsonrpc":"2.0","result":{"random":{"data":[60,7,21,99,97,88,53,5,70,41],"completionTime":"2023-07-22 11:23:14Z"},"bitsUsed":66,"bitsLeft":249802,"requestsLeft":997,"advisoryDelay":2290},"id":"generateIntegers_64bbbc22842dc8.38709527"}', true), $result);
    }

    public function testGetData(): void
    {
        $result = $this
            ->makeClient()
            ->getData(
                ApiMethods::GenerateIntegers,
                [
                    'n' => 10,
                    'min' => 1,
                    'max' => 100,
                ]
            );

        self::assertEquals([60, 7, 21, 99, 97, 88, 53, 5, 70, 41], $result);
    }

    public function testInvalidStatusCodeException(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Invalid status code: 500');

        $this
            ->makeClient()
            ->call(
                ApiMethods::GenerateStrings,
                [
                    'n' => 10,
                    'length' => 10,
                    'characters' => 'abc',
                ]
            );
    }

    public function testJsonRpcErrorException(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('JSON-RPC error: Invalid params, Invalid method parameter(s).');

        $this
            ->makeClient()
            ->call(
                ApiMethods::GenerateIntegers,
                [
                    'foobar' => 10,
                ]
            );
    }

    public function testUnableToCreateRequest(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Invalid request.');

        $psr17 = $this->createMock(Psr17Interface::class);
        $psr17
            ->method('createRequest')
            ->willThrowException(Exception::invalidRequest(new Error()));

        $this
            ->makeClient($psr17)
            ->call(
                ApiMethods::GetUsage,
                [],
                [
                    'foobar' => '\0',
                ]
            );
    }

    public function testUnableToDecodeJsonException(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Unable to decode JSON');

        $this
            ->makeClient()
            ->getData(
                ApiMethods::GenerateDecimalFractions,
                [
                    'n' => 10,
                    'decimalPlaces' => 1,
                ]
            );
    }

    public function testUnableToExtractResult(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Unable to extract result.');

        $this
            ->makeClient()
            ->getData(
                ApiMethods::GenerateUUIDs,
                [
                    'n' => 3,
                ]
            );
    }

    public function testUnableToSendRequest(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Unable to send request: Unable to find a response to replay request "api.random.org_POST_json-rpc_4_invoke_0a432".');

        $this
            ->makeClient()
            ->getData(
                ApiMethods::GenerateIntegerSequences,
                [
                    'n' => 10,
                    'min' => 1,
                    'max' => 100,
                    'length' => 2,
                ]
            );
    }

    private function makeClient(?Psr17Interface $psr17 = null): ClientInterface
    {
        $psr17 ??= new Psr17(
            new Psr17Factory(),
            new Psr17Factory(),
            new Psr17Factory(),
            new Psr17Factory(),
            new Psr17Factory(),
            new Psr17Factory(),
        );

        return new Client(
            $this->makeHttpClient($psr17),
            $psr17,
            getenv('RANDOM_ORG_APIKEY')
        );
    }

    private function makeHttpClient(Psr17Interface $psr17): HttpClientInterface
    {
        $customNamingStrategy = new class(new PathNamingStrategy(), $psr17) implements NamingStrategyInterface {
            public function __construct(
                private readonly NamingStrategyInterface $namingStrategy,
                private readonly Psr17Interface $psr17
            ) {}

            public function name(RequestInterface $request): string
            {
                $jsonDecoded = json_decode(
                    (string) $request->getBody(),
                    true,
                    512,
                    JSON_THROW_ON_ERROR
                );
                $jsonDecoded['id'] = $jsonDecoded['method'];

                return $this
                    ->namingStrategy
                    ->name(
                        $request
                            ->withBody(
                                $this
                                    ->psr17
                                    ->createStream(
                                        json_encode($jsonDecoded)
                                    )
                            )
                    );
            }
        };

        $recorder = new FilesystemRecorder('tests/fixtures');
        $record = new RecordPlugin($customNamingStrategy, $recorder);
        $replay = new ReplayPlugin($customNamingStrategy, $recorder);

        return new PluginClient(new HttpClient(), [$record, $replay]);
    }
}
