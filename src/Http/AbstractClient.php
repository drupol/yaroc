<?php

declare(strict_types=1);

namespace drupol\Yaroc\Http;

use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Message\MessageFactory;

/**
 * Class AbstractClient.
 */
abstract class AbstractClient
{
    /**
     * The HTTP client.
     *
     * @var \Http\Client\HttpClient
     */
    private $httpClient;

    /**
     * The HTTP message factory.
     *
     * @var \Http\Message\MessageFactory|null
     */
    private $messageFactory;

    /**
     * AbstractClient constructor.
     *
     * @param \Http\Client\HttpClient $client
     * @param \Http\Message\MessageFactory|null $messageFactory
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function __construct(HttpClient $client = null, MessageFactory $messageFactory = null)
    {
        $this->httpClient = $client ?? HttpClientDiscovery::find();
        $this->messageFactory = $messageFactory ?? MessageFactoryDiscovery::find();
    }

    /**
     * @param \Http\Client\HttpClient $httpClient
     *
     * @return \drupol\Yaroc\Http\AbstractClient
     */
    public function withHttpClient(HttpClient $httpClient) :AbstractClient
    {
        $clone = clone $this;
        $clone->httpClient = $httpClient;

        return $clone;
    }

    /**
     * Returns the HTTP adapter.
     *
     * @return HttpClient
     */
    public function getHttpClient(): HttpClient
    {
        return $this->httpClient;
    }

    /**
     * Get the message factory.
     *
     * @return MessageFactory
     */
    public function getMessageFactory(): MessageFactory
    {
        return $this->messageFactory;
    }
}
