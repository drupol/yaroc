<?php

declare(strict_types = 1);

namespace drupol\Yaroc\Plugin;

use drupol\Yaroc\Http\AbstractClient;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

/**
 * Class AbstractProvider.
 */
abstract class AbstractProvider extends AbstractClient implements ProviderInterface
{
    /**
     * The endpoint.
     *
     * @var string
     */
    private $endpoint = '';

    /**
     * The parameters.
     *
     * @var array
     */
    private $parameters = [];

    /**
     * The random.org resource.
     *
     * @var string
     */
    private $resource;

    /**
     * {@inheritdoc}
     */
    public function getEndPoint(): string
    {
        return $this->endpoint;
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
    public function getResource(): string
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
                'id' => uniqid($this->getResource() . '_', true),
                'params' => $this->getParameters(),
                'method' => $this->getResource(),
            ],
        ];

        try {
            $response = $this->getHttpClient()->request('POST', $this->getEndPoint(), $options);
        } catch (ExceptionInterface $exception) {
            throw new \Exception($exception->getMessage());
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
