<?php

declare(strict_types=1);

namespace drupol\Yaroc;

use BadFunctionCallException;
use drupol\Yaroc\Http\Client;
use drupol\Yaroc\Plugin\ProviderInterface;
use InvalidArgumentException;
use RuntimeException;
use Symfony\Contracts\HttpClient\Exception\HttpExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class RandomOrgAPI implements RandomOrgAPIInterface
{
    /**
     * The configuration.
     */
    private array $configuration;

    /**
     * The default Random.org endpoint.
     */
    private string $endpoint = 'https://api.random.org/json-rpc/2/invoke';

    /**
     * The HTTP client.
     */
    private HttpClientInterface $httpClient;

    public function __construct(?HttpClientInterface $httpClient = null, array $configuration = [])
    {
        $this->httpClient = new Client($httpClient);
        $this->configuration = $configuration;
    }

    public function call(ProviderInterface $methodPlugin): ResponseInterface
    {
        $parameters = $methodPlugin->getParameters() +
            ['apiKey' => $this->getApiKey()];

        try {
            $response = $methodPlugin
                ->withEndPoint($this->getEndPoint())
                ->withHttpClient($this->getHttpClient())
                ->withParameters($parameters)
                ->request();
        } catch (HttpExceptionInterface $exception) {
            throw $exception;
        }

        return $this->validateResponse($response);
    }

    public function get(ProviderInterface $methodPlugin): array
    {
        return $this->call($methodPlugin)->toArray();
    }

    public function getApiKey(): string
    {
        $configuration = $this->getConfiguration();

        return $configuration['apiKey'] ?? '';
    }

    public function getConfiguration(): array
    {
        return $this->configuration;
    }

    public function getData(ProviderInterface $methodPlugin): ?array
    {
        return $this->get($methodPlugin)['result']['random']['data'] ?? null;
    }

    public function getEndPoint(): string
    {
        return $this->endpoint;
    }

    public function getHttpClient(): HttpClientInterface
    {
        return $this->httpClient;
    }

    public function withApiKey(string $apikey): RandomOrgAPIInterface
    {
        $clone = clone $this;

        $configuration = $clone->getConfiguration();
        $configuration['apiKey'] = $apikey;
        $clone->configuration = $configuration;

        return $clone;
    }

    public function withEndPoint(string $endpoint): RandomOrgAPIInterface
    {
        $clone = clone $this;
        $clone->endpoint = $endpoint;

        return $clone;
    }

    public function withHttpClient(HttpClientInterface $client): RandomOrgAPIInterface
    {
        $clone = clone $this;
        $clone->httpClient = $client;

        return $clone;
    }

    /**
     * Validate the response.
     *
     * @throws \Symfony\Contracts\HttpClient\Exception\ExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    private function validateResponse(ResponseInterface $response): ResponseInterface
    {
        if (200 === $response->getStatusCode()) {
            try {
                $body = $response->toArray();
            } catch (HttpExceptionInterface $exception) {
                throw $exception;
            }

            if (isset($body['error']['code'])) {
                switch ($body['error']['code']) {
                    case -32600:
                        throw new InvalidArgumentException(
                            'Invalid Request: ' . $body['error']['message'],
                            $body['error']['code']
                        );

                    case -32601:
                        throw new BadFunctionCallException(
                            'Procedure not found: ' . $body['error']['message'],
                            $body['error']['code']
                        );

                    case -32602:
                        throw new InvalidArgumentException(
                            'Invalid arguments: ' . $body['error']['message'],
                            $body['error']['code']
                        );

                    case -32603:
                        throw new RuntimeException(
                            'Internal Error: ' . $body['error']['message'],
                            $body['error']['code']
                        );

                    default:
                        throw new RuntimeException(
                            'Invalid request/response: ' . $body['error']['message'],
                            $body['error']['code']
                        );
                }
            }
        }

        return $response;
    }
}
