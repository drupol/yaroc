<?php

declare(strict_types=1);

namespace drupol\Yaroc;

use drupol\Yaroc\Plugin\ProviderInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

interface RandomOrgAPIInterface
{
    public function call(ProviderInterface $methodPlugin): ResponseInterface;

    public function get(ProviderInterface $methodPlugin): array;

    /**
     * Get the Random.org API Key.
     *
     * @return string
     *   The API Key
     */
    public function getApiKey(): string;

    public function getData(ProviderInterface $methodPlugin): ?array;

    /**
     * Get the API endpoint.
     */
    public function getEndPoint(): string;

    /**
     * Get the HTTP client.
     */
    public function getHttpClient(): HttpClientInterface;

    /**
     * @return \drupol\Yaroc\RandomOrgAPI
     */
    public function withApiKey(string $apikey): self;

    /**
     * @return \drupol\Yaroc\RandomOrgAPI
     */
    public function withEndPoint(string $endpoint): self;

    /**
     * @return \drupol\Yaroc\RandomOrgAPI
     */
    public function withHttpClient(HttpClientInterface $client): self;
}
