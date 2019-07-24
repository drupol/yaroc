<?php

declare(strict_types = 1);

namespace drupol\Yaroc\Http;

use Symfony\Component\HttpClient\NativeHttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Class AbstractClient.
 */
abstract class AbstractClient
{
    /**
     * The HTTP client.
     *
     * @var \Symfony\Contracts\HttpClient\HttpClientInterface
     */
    private $httpClient;

    /**
     * AbstractClient constructor.
     *
     * @param \Symfony\Contracts\HttpClient\HttpClientInterface $client
     */
    public function __construct(HttpClientInterface $client = null)
    {
        $this->httpClient = $client ?? new NativeHttpClient();
    }

    /**
     * Returns the HTTP adapter.
     *
     * @return HttpClientInterface
     */
    public function getHttpClient(): HttpClientInterface
    {
        return $this->httpClient;
    }

    /**
     * @param \Symfony\Contracts\HttpClient\HttpClientInterface $httpClient
     *
     * @return \drupol\Yaroc\Http\AbstractClient
     */
    public function withHttpClient(HttpClientInterface $httpClient): self
    {
        $clone = clone $this;
        $clone->httpClient = $httpClient;

        return $clone;
    }
}
