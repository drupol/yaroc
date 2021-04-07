<?php

declare(strict_types=1);

namespace drupol\Yaroc\Plugin;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

interface ProviderInterface
{
    public function getEndpoint(): ?string;

    /**
     * Get the HTTP client.
     */
    public function getHttpClient(): HttpClientInterface;

    /**
     * Get the parameters.
     */
    public function getParameters(): array;

    /**
     * Get the resource name.
     *
     * @return string
     */
    public function getResource(): ?string;

    /**
     * Do the request.
     */
    public function request(): ResponseInterface;

    public function withEndPoint(string $endpoint): self;

    public function withHttpClient(HttpClientInterface $httpClient): self;

    public function withParameters(array $parameters): self;

    public function withResource(string $resource): self;
}
