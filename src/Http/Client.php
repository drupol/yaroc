<?php

declare(strict_types=1);

namespace drupol\Yaroc\Http;

use Symfony\Component\HttpClient\NativeHttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Symfony\Contracts\HttpClient\ResponseStreamInterface;

final class Client implements HttpClientInterface
{
    /**
     * The HTTP client.
     */
    private HttpClientInterface $httpClient;

    public function __construct(?HttpClientInterface $httpClient = null)
    {
        $this->httpClient = $httpClient ?? new NativeHttpClient();
    }

    public function request(string $method, string $url, array $options = []): ResponseInterface
    {
        $options['headers']['User-Agent'] = 'YAROC (http://github.com/drupol/yaroc)';

        return $this->httpClient->request($method, $url, $options);
    }

    public function stream($responses, ?float $timeout = null): ResponseStreamInterface
    {
        return $this->httpClient->stream($responses, $timeout);
    }
}
