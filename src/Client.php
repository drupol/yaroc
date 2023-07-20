<?php

declare(strict_types=1);

namespace drupol\Yaroc;

use Ergebnis\Http\Method;
use loophp\psr17\Psr17Interface;
use Psr\Http\Client\ClientInterface as HttpClientInterface;
use Psr\Http\Message\ResponseInterface;
use Throwable;

use const JSON_THROW_ON_ERROR;

/**
 * @psalm-type JsonRpcReturnType = array{id: string, jsonrpc: string, error?: array{code: int, message: string, data?: mixed}, method: string, params?: array<string, mixed>, result?: array{random?: array{data?: array<mixed>}}}
 */
final class Client implements ClientInterface
{
    private const API_ENDPOINT = 'https://api.random.org/json-rpc/4/invoke';

    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly Psr17Interface $psr17,
        private readonly string $apiKey = ''
    ) {}

    public function call(ApiMethods $method, array $parameters = [], array $body = []): ResponseInterface
    {
        try {
            $request = $this
                ->psr17
                ->createRequest(
                    Method::POST,
                    $this->psr17->createUri(self::API_ENDPOINT)
                )
                ->withHeader('Content-Type', 'application/json')
                ->withBody(
                    $this->psr17->createStream(
                        json_encode(
                            $body + [
                                'jsonrpc' => '2.0',
                                'id' => uniqid($method->value . '_', true),
                                'params' => $parameters + ['apiKey' => $this->apiKey],
                                'method' => $method->value,
                            ],
                            JSON_THROW_ON_ERROR
                        )
                    )
                );
        } catch (Throwable $e) {
            throw Exception::invalidRequest($e);
        }

        try {
            $response = $this->httpClient->sendRequest($request);
        } catch (Throwable $e) {
            throw Exception::unableToSendRequest($e);
        }

        return $this->validateResponse($response);
    }

    public function get(ApiMethods $method, array $parameters = []): array
    {
        return $this->toArray($this->call($method, $parameters));
    }

    public function getData(ApiMethods $method, array $parameters = []): array
    {
        $data = $this->get($method, $parameters);

        if (!isset($data['result']['random']['data'])) {
            throw Exception::unableToExtractResult();
        }

        return $data['result']['random']['data'];
    }

    /**
     * @return JsonRpcReturnType
     */
    private function toArray(ResponseInterface $response): array
    {
        try {
            /** @var JsonRpcReturnType $json */
            $json = json_decode((string) $response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        } catch (Throwable $e) {
            throw Exception::unableToDecodeJson($e);
        }

        return $json;
    }

    private function validateResponse(ResponseInterface $response): ResponseInterface
    {
        if (200 !== $response->getStatusCode()) {
            throw Exception::invalidStatusCode($response->getStatusCode());
        }

        $body = $this->toArray($response);

        if (isset($body['error']['code'])) {
            throw Exception::jsonRpcError($body['error']['code']);
        }

        return $response;
    }
}
