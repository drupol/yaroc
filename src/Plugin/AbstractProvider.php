<?php

declare(strict_types = 1);

namespace drupol\Yaroc\Plugin;

use drupol\Yaroc\Http\AbstractClient;
use Http\Client\Exception\HttpException;
use Psr\Http\Message\ResponseInterface;

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
        $body = (string) \json_encode([
            'jsonrpc' => '2.0',
            'id' => \uniqid($this->getResource() . '_', true),
            'params' => $this->getParameters(),
            'method' => $this->getResource(),
        ]);

        try {
            $response = $this->getHttpClient()->sendRequest(
                $this->getMessageFactory()->createRequest(
                    'POST',
                    $this->getEndPoint(),
                    [],
                    $body
                )
            );
        } catch (HttpException $exception) {
            throw new \Exception($exception->getMessage());
        } catch (\Exception $exception) {
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
    public static function withResource(string $resource): ProviderInterface
    {
        $clone = new static();
        $clone->resource = $resource;

        return $clone;
    }
}
