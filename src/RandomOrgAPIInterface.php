<?php

namespace drupol\Yaroc;

use drupol\Yaroc\Plugin\ProviderInterface;
use Http\Client\HttpClient;
use Psr\Http\Message\ResponseInterface;

/**
 * Class RandomOrgAPIInterface.
 */
interface RandomOrgAPIInterface
{
    /**
     * @param string $apikey
     *
     * @return \drupol\Yaroc\RandomOrgAPI
     */
    public function withApiKey(string $apikey) :RandomOrgAPIInterface;

    /**
     * @param \Http\Client\HttpClient $client
     *
     * @return \drupol\Yaroc\RandomOrgAPI
     */
    public function withHttpClient(HttpClient $client) :RandomOrgAPIInterface;

    /**
     * @param string $endpoint
     *
     * @return \drupol\Yaroc\RandomOrgAPI
     */
    public function withEndPoint(string $endpoint) :RandomOrgAPIInterface;

    /**
     * Get the API endpoint.
     *
     * @return string
     */
    public function getEndPoint() :string;

    /**
     * Get the HTTP client.
     *
     * @return \Http\Client\HttpClient
     */
    public function getHttpClient() :HttpClient;

    /**
     * Get the Random.org API Key.
     *
     * @return string
     *   The API Key.
     */
    public function getApiKey() :string;

    /**
     * @param \drupol\Yaroc\Plugin\ProviderInterface $methodPlugin
     *
     * @throws \Http\Client\Exception
     *
     * @return \Exception|\Psr\Http\Message\ResponseInterface
     */
    public function call(ProviderInterface $methodPlugin) :ResponseInterface;

    /**
     * @param \drupol\Yaroc\Plugin\ProviderInterface $methodPlugin
     *
     * @throws \Http\Client\Exception
     *
     * @return array
     */
    public function get(ProviderInterface $methodPlugin) :array;

    /**
     * @param \drupol\Yaroc\Plugin\ProviderInterface $methodPlugin
     *
     * @throws \Http\Client\Exception
     *
     * @return array|false
     */
    public function getData(ProviderInterface $methodPlugin);

    /**
     * @return array
     */
    public function getConfiguration() :array;
}
