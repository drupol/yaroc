<?php

declare(strict_types = 1);

namespace drupol\Yaroc\Plugin;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

interface ProviderInterface
{
    /**
     * Get the HTTP client.
     *
     * @return \Symfony\Contracts\HttpClient\HttpClientInterface
     */
    public function getHttpClient(): HttpClientInterface;

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
     * @return \Symfony\Contracts\HttpClient\ResponseInterface
     */
    public function request(): ResponseInterface;

    /**
     * @param string $endpoint
     *
     * @return ProviderInterface
     */
    public function withEndPoint(string $endpoint): self;

    /**
     * @param \Symfony\Contracts\HttpClient\HttpClientInterface $httpClient
     *
     * @return ProviderInterface
     */
    public function withHttpClient(HttpClientInterface $httpClient);

    /**
     * @param array $parameters
     *
     * @return ProviderInterface
     */
    public function withParameters(array $parameters): self;

    /**
     * @param string $resource
     *
     * @return ProviderInterface
     */
    public function withResource(string $resource): self;
}
