<?php

declare(strict_types = 1);

namespace drupol\Yaroc;

use drupol\Yaroc\Plugin\ProviderInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

/**
 * Class RandomOrgAPIInterface.
 */
interface RandomOrgAPIInterface
{
    /**
     * @param \drupol\Yaroc\Plugin\ProviderInterface $methodPlugin
     *
     * @return \Symfony\Contracts\HttpClient\ResponseInterface
     */
    public function call(ProviderInterface $methodPlugin): ResponseInterface;

    /**
     * @param \drupol\Yaroc\Plugin\ProviderInterface $methodPlugin
     *
     * @return array
     */
    public function get(ProviderInterface $methodPlugin): array;

    /**
     * Get the Random.org API Key.
     *
     * @return string
     *   The API Key
     */
    public function getApiKey(): string;

    /**
     * @return array
     */
    public function getConfiguration(): array;

    /**
     * @param \drupol\Yaroc\Plugin\ProviderInterface $methodPlugin
     *
     * @return array|false
     */
    public function getData(ProviderInterface $methodPlugin);

    /**
     * Get the API endpoint.
     *
     * @return string
     */
    public function getEndPoint(): string;

    /**
     * Get the HTTP client.
     *
     * @return \Symfony\Contracts\HttpClient\HttpClientInterface
     */
    public function getHttpClient(): HttpClientInterface;

    /**
     * @param string $apikey
     *
     * @return \drupol\Yaroc\RandomOrgAPI
     */
    public function withApiKey(string $apikey): self;

    /**
     * @param string $endpoint
     *
     * @return \drupol\Yaroc\RandomOrgAPI
     */
    public function withEndPoint(string $endpoint): self;

    /**
     * @param \Symfony\Contracts\HttpClient\HttpClientInterface $client
     *
     * @return \drupol\Yaroc\RandomOrgAPI
     */
    public function withHttpClient(HttpClientInterface $client): self;
}
