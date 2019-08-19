<?php

declare(strict_types=1);

namespace drupol\Yaroc\Plugin;

use drupol\Yaroc\Http\Client;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

/**
 * Class AbstractProvider.
 */
abstract class AbstractProvider implements ProviderInterface
{
    /**
     * The endpoint.
     *
     * @var null|string
     */
    private $endpoint;

    /**
     * @var HttpClientInterface
     */
    private $httpClient;

    /**
     * The parameters.
     *
     * @var array
     */
    private $parameters;

    /**
     * The random.org resource.
     *
     * @var null|string
     */
    private $resource;

    /**
     * Provider constructor.
     *
     * @param \Symfony\Contracts\HttpClient\HttpClientInterface $client
     * @param string $endpoint
     * @param string $resource
     * @param array $parameters
     */
    public function __construct(
        HttpClientInterface $client = null,
        string $endpoint = null,
        string $resource = null,
        array $parameters = []
    ) {
        $this->httpClient = $client ?? new Client();
        $this->endpoint = $endpoint;
        $this->resource = $resource;
        $this->parameters = $parameters;
    }

    /**
     * {@inheritdoc}
     */
    public function getEndPoint(): ?string
    {
        return $this->endpoint;
    }

    /**
     * {@inheritdoc}
     */
    public function getHttpClient(): HttpClientInterface
    {
        return $this->httpClient;
    }

    /**
     * {@inheritdoc}
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * {@inheritdoc}
     */
    public function getResource(): ?string
    {
        return $this->resource;
    }

    /**
     * {@inheritdoc}
     */
    public function request(): ResponseInterface
    {
        $options = [
            'json' => [
                'jsonrpc' => '2.0',
                'id' => \uniqid($this->getResource() . '_', true),
                'params' => $this->getParameters(),
                'method' => $this->getResource(),
            ],
        ];

        if (null === $this->getEndPoint()) {
            throw new \Exception('You must set an endpoint.');
        }

        try {
            $response = $this->getHttpClient()->request('POST', $this->getEndPoint(), $options);
        } catch (TransportExceptionInterface $exception) {
            throw $exception;
        }

        return $response;
    }

    /**
     * {@inheritdoc}
     */
    public function withEndPoint(string $endpoint): ProviderInterface
    {
        $clone = clone $this;
        $clone->endpoint = $endpoint;

        return $clone;
    }

    /**
     * {@inheritdoc}
     */
    public function withHttpClient(HttpClientInterface $httpClient)
    {
        $clone = clone $this;
        $clone->httpClient = $httpClient;

        return $clone;
    }

    /**
     * {@inheritdoc}
     */
    public function withParameters(array $parameters): ProviderInterface
    {
        $clone = clone $this;
        $clone->parameters = $parameters;

        return $clone;
    }

    /**
     * {@inheritdoc}
     */
    public function withResource(string $resource): ProviderInterface
    {
        $clone = clone $this;
        $clone->resource = $resource;

        return $clone;
    }
}
