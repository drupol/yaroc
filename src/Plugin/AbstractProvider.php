<?php

declare(strict_types=1);

namespace drupol\Yaroc\Plugin;

use drupol\Yaroc\Http\Client;
use Exception;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

abstract class AbstractProvider implements ProviderInterface
{
    /**
     * The endpoint.
     */
    private ?string $endpoint;

    private HttpClientInterface $httpClient;

    /**
     * The parameters.
     */
    private array $parameters;

    /**
     * The random.org resource.
     */
    private ?string $resource;

    public function __construct(
        ?HttpClientInterface $client = null,
        ?string $endpoint = null,
        ?string $resource = null,
        array $parameters = []
    ) {
        $this->httpClient = $client ?? new Client();
        $this->endpoint = $endpoint;
        $this->resource = $resource;
        $this->parameters = $parameters;
    }

    public function getEndPoint(): ?string
    {
        return $this->endpoint;
    }

    public function getHttpClient(): HttpClientInterface
    {
        return $this->httpClient;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function getResource(): ?string
    {
        return $this->resource;
    }

    public function request(): ResponseInterface
    {
        $options = [
            'json' => [
                'jsonrpc' => '2.0',
                'id' => uniqid($this->getResource() . '_', true),
                'params' => $this->getParameters(),
                'method' => $this->getResource(),
            ],
        ];

        if (null === $this->getEndPoint()) {
            throw new Exception('You must set an endpoint.');
        }

        try {
            $response = $this->getHttpClient()->request('POST', $this->getEndPoint(), $options);
        } catch (TransportExceptionInterface $exception) {
            throw $exception;
        }

        return $response;
    }

    public function withEndPoint(string $endpoint): ProviderInterface
    {
        $clone = clone $this;
        $clone->endpoint = $endpoint;

        return $clone;
    }

    public function withHttpClient(HttpClientInterface $httpClient): ProviderInterface
    {
        $clone = clone $this;
        $clone->httpClient = $httpClient;

        return $clone;
    }

    public function withParameters(array $parameters): ProviderInterface
    {
        $clone = clone $this;
        $clone->parameters = $parameters;

        return $clone;
    }

    public function withResource(string $resource): ProviderInterface
    {
        $clone = clone $this;
        $clone->resource = $resource;

        return $clone;
    }
}
