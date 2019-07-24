<?php

declare(strict_types = 1);

namespace drupol\Yaroc;

use drupol\Yaroc\Plugin\ProviderInterface;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\HttpClient\NativeHttpClient;
use Symfony\Contracts\HttpClient\Exception\HttpExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

/**
 * Class RandomOrgAPI.
 */
final class RandomOrgAPI implements RandomOrgAPIInterface
{
    /**
     * The configuration.
     *
     * @var array
     */
    private $configuration;

    /**
     * The default Random.org endpoint.
     *
     * @var string;
     */
    private $endpoint = 'https://api.random.org/json-rpc/1/invoke';

    /**
     * The HTTP client.
     *
     * @var \Symfony\Contracts\HttpClient\HttpClientInterface
     */
    private $httpClient;

    /**
     * RandomOrgAPI constructor.
     *
     * @param \Symfony\Contracts\HttpClient\HttpClientInterface $httpClient
     *   The HTTP client
     * @param array $configuration
     *   The configuration array
     */
    public function __construct(HttpClientInterface $httpClient = null, array $configuration = [])
    {
        if (null === $httpClient) {
            $httpClient = new NativeHttpClient(
                [
                    'headers' => [
                        'User-Agent' => 'YAROC (http://github.com/drupol/yaroc)',
                    ],
                ]
            );
        }

        $this->httpClient = $httpClient;

        $dotenv = new Dotenv();
        $files = array_filter(
            [
                __DIR__ . '/../.env.dist',
                __DIR__ . '/../.env',
            ],
            'file_exists'
        );
        $dotenv->load(...$files);

        if ($apikey = getenv('RANDOM_ORG_APIKEY')) {
            $configuration += ['apiKey' => $apikey];
        }

        $this->configuration = $configuration;
    }

    /**
     * {@inheritdoc}
     */
    public function call(ProviderInterface $methodPlugin): ResponseInterface
    {
        $parameters = $methodPlugin->getParameters() +
            ['apiKey' => $this->getApiKey()];

        try {
            $response = $methodPlugin
                ->withEndPoint($this->getEndPoint())
                ->withHttpClient($this->getHttpClient())
                ->withParameters($parameters)
                ->request();
        } catch (HttpExceptionInterface $exception) {
            throw $exception;
        }

        return $this->validateResponse($response);
    }

    /**
     * {@inheritdoc}
     */
    public function get(ProviderInterface $methodPlugin): array
    {
        return $this->call($methodPlugin)->toArray();
    }

    /**
     * {@inheritdoc}
     */
    public function getApiKey(): string
    {
        $configuration = $this->getConfiguration();

        return $configuration['apiKey'] ?? '';
    }

    /**
     * {@inheritdoc}
     */
    public function getConfiguration(): array
    {
        return $this->configuration;
    }

    /**
     * {@inheritdoc}
     */
    public function getData(ProviderInterface $methodPlugin)
    {
        $data = $this->get($methodPlugin);

        if (!isset($data['result'])) {
            return false;
        }

        if (isset($data['result']['random']['data'])) {
            return $data['result']['random']['data'];
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getEndPoint(): string
    {
        return $this->endpoint;
    }

    /**
     * {@inheritdoc}
     */
    public function getHttpClient(): HttpClientInterface
    {
        return $this->httpClient;
    }

    /**
     * {@inheritdoc}
     */
    public function withApiKey(string $apikey): RandomOrgAPIInterface
    {
        $clone = clone $this;

        $configuration = $clone->getConfiguration();
        $configuration['apiKey'] = $apikey;
        $clone->configuration = $configuration;

        return $clone;
    }

    /**
     * {@inheritdoc}
     */
    public function withEndPoint(string $endpoint): RandomOrgAPIInterface
    {
        $clone = clone $this;
        $clone->endpoint = $endpoint;

        return $clone;
    }

    /**
     * {@inheritdoc}
     */
    public function withHttpClient(HttpClientInterface $client): RandomOrgAPIInterface
    {
        $clone = clone $this;
        $clone->httpClient = $client;

        return $clone;
    }

    /**
     * Validate the response.
     *
     * @param \Symfony\Contracts\HttpClient\ResponseInterface $response
     *
     * @throws \Symfony\Contracts\HttpClient\Exception\ExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     *
     * @return ResponseInterface
     */
    private function validateResponse(ResponseInterface $response): ResponseInterface
    {
        if (200 === $response->getStatusCode()) {
            try {
                $body = $response->toArray();
            } catch (HttpExceptionInterface $exception) {
                throw $exception;
            }

            if (isset($body['error']['code'])) {
                switch ($body['error']['code']) {
                    case -32600:
                        throw new \InvalidArgumentException(
                            'Invalid Request: ' . $body['error']['message'],
                            $body['error']['code']
                        );

                    case -32601:
                        throw new \BadFunctionCallException(
                            'Procedure not found: ' . $body['error']['message'],
                            $body['error']['code']
                        );

                    case -32602:
                        throw new \InvalidArgumentException(
                            'Invalid arguments: ' . $body['error']['message'],
                            $body['error']['code']
                        );

                    case -32603:
                        throw new \RuntimeException(
                            'Internal Error: ' . $body['error']['message'],
                            $body['error']['code']
                        );

                    default:
                        throw new \RuntimeException(
                            'Invalid request/response: ' . $body['error']['message'],
                            $body['error']['code']
                        );
                }
            }
        }

        return $response;
    }
}
