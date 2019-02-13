<?php

declare(strict_types = 1);

namespace drupol\Yaroc;

use drupol\Yaroc\Plugin\ProviderInterface;
use Http\Client\Common\Plugin\HeaderDefaultsPlugin;
use Http\Client\Common\Plugin\RetryPlugin;
use Http\Client\Common\PluginClient;
use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\Dotenv\Dotenv;

/**
 * Class RandomOrgAPI.
 */
class RandomOrgAPI implements RandomOrgAPIInterface
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
     * @var \Http\Client\HttpClient
     */
    private $httpClient;

    /**
     * RandomOrgAPI constructor.
     *
     * @param \Http\Client\HttpClient $httpClient
     *   The HTTP client
     * @param array $configuration
     *   The configuration array
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function __construct(HttpClient $httpClient = null, array $configuration = [])
    {
        if (null === $httpClient) {
            $httpClient = new PluginClient(
                HttpClientDiscovery::find(),
                [
                    new HeaderDefaultsPlugin([
                        'Content-Type' => 'application/json',
                        'User-Agent' => 'YAROC (http://github.com/drupol/yaroc)',
                    ]),
                    new RetryPlugin([
                        'retries' => 5,
                    ]),
                ]
            );
        }

        $this->httpClient = $httpClient;

        $dotenv = new Dotenv();
        $files = \array_filter(
            [
                __DIR__ . '/../.env.dist',
                __DIR__ . '/../.env',
            ],
            'file_exists'
        );
        $dotenv->load(...$files);

        if ($apikey = \getenv('RANDOM_ORG_APIKEY')) {
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

        return $this->validateResponse(
            $methodPlugin
                ->withEndPoint($this->getEndPoint())
                ->withHttpClient($this->getHttpClient())
                ->withParameters($parameters)
                ->request()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function get(ProviderInterface $methodPlugin): array
    {
        return \json_decode(
            $this
                ->call($methodPlugin)
                ->getBody()
                ->getContents(),
            true
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getApiKey(): string
    {
        $configuration = $this->getConfiguration();

        return isset($configuration['apiKey']) ? $configuration['apiKey'] : '';
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
    public function getHttpClient(): HttpClient
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
    public function withHttpClient(HttpClient $client): RandomOrgAPIInterface
    {
        $clone = clone $this;
        $clone->httpClient = $client;

        return $clone;
    }

    /**
     * Validate the response.
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return ResponseInterface
     */
    private function validateResponse(ResponseInterface $response): ResponseInterface
    {
        if (200 === $response->getStatusCode()) {
            $body = \json_decode($response->getBody()->getContents(), true);

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

        $response->getBody()->rewind();

        return $response;
    }
}
