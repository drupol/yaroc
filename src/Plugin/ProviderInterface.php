<?php

namespace drupol\Yaroc\Plugin;

use Http\Client\HttpClient;
use Psr\Http\Message\ResponseInterface;

interface ProviderInterface
{
    /**
     * @param string $endpoint
     *
     * @return $this
     */
    public function withEndPoint(string $endpoint) :ProviderInterface;

    /**
     * @param array $parameters
     *
     * @return $this
     */
    public function withParameters(array $parameters) :ProviderInterface;

    /**
     * @param \Http\Client\HttpClient $httpClient
     *
     * @return $this
     */
    public function withHttpClient(HttpClient $httpClient);

    /**
     * @param string $resource
     *
     * @return \drupol\Yaroc\Plugin\ProviderInterface
     */
    public static function withResource(string $resource) :ProviderInterface;

    /**
     * Get the HTTP client.
     *
     * @return \Http\Client\HttpClient
     */
    public function getHttpClient() :HttpClient;

    /**
     * Get the resource name.
     *
     * @return string
     */
    public function getResource() :string;

    /**
     * Get the parameters.
     *
     * @return array
     */
    public function getParameters() :array;

    /**
     * Do the request.
     *
     * @throws \Exception|\Http\Client\Exception
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function request() :ResponseInterface;
}
