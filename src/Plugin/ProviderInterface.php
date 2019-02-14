<?php

declare(strict_types = 1);

namespace drupol\Yaroc\Plugin;

use Http\Client\HttpClient;
use Psr\Http\Message\ResponseInterface;

interface ProviderInterface
{
    /**
     * Get the HTTP client.
     *
     * @return \Http\Client\HttpClient
     */
    public function getHttpClient(): HttpClient;

    /**
     * Get the parameters.
     *
     * @return array
     */
    public function getParameters(): array;

    /**
     * Get the resource name.
     *
     * @return string
     */
    public function getResource(): string;

    /**
     * Do the request.
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function request(): ResponseInterface;

    /**
     * @param string $endpoint
     *
     * @return ProviderInterface
     */
    public function withEndPoint(string $endpoint): ProviderInterface;

    /**
     * @param \Http\Client\HttpClient $httpClient
     *
     * @return ProviderInterface
     */
    public function withHttpClient(HttpClient $httpClient);

    /**
     * @param array $parameters
     *
     * @return ProviderInterface
     */
    public function withParameters(array $parameters): ProviderInterface;

    /**
     * @param string $resource
     *
     * @return ProviderInterface
     */
    public function withResource(string $resource): ProviderInterface;
}
