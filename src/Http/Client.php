<?php

namespace drupol\Yaroc\Http;

use drupol\Yaroc\Plugin\MethodPluginInterface;
use Http\Client\Common\HttpMethodsClient;
use Http\Client\Common\Plugin;
use Http\Client\Common\Plugin\HeaderDefaultsPlugin;
use Http\Client\Common\PluginClient;
use Http\Client\Exception\NetworkException;
use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Discovery\UriFactoryDiscovery;
use Http\Message\UriFactory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use Psr\Log\LoggerInterface;

/**
 * Class Client
 *
 * @package drupol\Yaroc\Http
 */
class Client extends HttpMethodsClient {

  /**
   * The default Random.org endpoint.
   *
   * @var UriInterface
   */
  protected $endpoint;

  /**
   * The URI Factory.
   *
   * @var UriFactory
   */
  protected $uriFactory;

  /**
   * The HTTP plugins array.
   *
   * @var Plugin[]
   */
  protected $plugins;

  /**
   * Client constructor.
   *
   * @param \Http\Client\HttpClient|NULL $httpClient
   * @param \Http\Message\UriFactory|NULL $uriFactory
   */
  public function __construct(HttpClient $httpClient = NULL, UriFactory $uriFactory = NULL) {
    $httpClient = $httpClient ?: HttpClientDiscovery::find();
    $httpClient = new HttpMethodsClient(new PluginClient($httpClient, $this->setPlugins()->getPlugins()), MessageFactoryDiscovery::find());
    $this->setUriFactory($uriFactory ?: UriFactoryDiscovery::find());

    parent::__construct($httpClient, MessageFactoryDiscovery::find());
  }

  /**
   * Get the HTTP plugins array.
   *
   * @return Plugin[]
   */
  public function getPlugins() {
    return $this->plugins;
  }

  /**
   * Set the HTTP plugins.
   *
   * @param Plugin[] $plugins
   *   An array of HTTP plugin.
   *
   * @return $this
   */
  public function setPlugins(array $plugins = array()) {
    $defaultPlugins = [
      new HeaderDefaultsPlugin(['Content-Type' => 'application/json'])
    ];

    $this->plugins = array_merge($defaultPlugins, $plugins);

    return $this;
  }

  /**
   * Set the Random.org endpoint.
   *
   * @param string $uri
   */
  public function setEndpoint($uri) {
    $this->endpoint = $this->getUriFactory()->createUri($uri);
  }

  /**
   * Get the Random.org endpoint.
   *
   * @return UriInterface
   */
  public function getEndpoint() {
    return $this->endpoint;
  }

  /**
   * Request.
   *
   * @param MethodPluginInterface $methodPlugin
   *
   * @return null|ResponseInterface
   */
  public function request(MethodPluginInterface $methodPlugin) {
    try {
      $response = $this->post($this->getEndpoint(), [], json_encode($methodPlugin->getParameters()));
    } catch (NetworkException $e) {
      return NULL;
    }

    return $this->validateResponse($response);
  }

  /**
   * Validate the response.
   *
   * @param \Psr\Http\Message\ResponseInterface $response
   *
   * @return \Exception|ResponseInterface
   */
  public function validateResponse(ResponseInterface $response) {
    if (200 == $response->getStatusCode()) {
      $body = json_decode((string) $response->getBody()->getContents(), TRUE);

      if (isset($body['error']['code'])) {
        switch ($body['error']['code']) {
          case -32600:
            throw new \InvalidArgumentException('Invalid Request: ' . $body['error']['message'], $body['error']['code']);
          case -32601:
            throw new \BadFunctionCallException('Procedure not found: ' . $body['error']['message'], $body['error']['code']);
          case -32602:
            throw new \InvalidArgumentException('Invalid arguments: ' . $body['error']['message'], $body['error']['code']);
          case -32603:
            throw new \RuntimeException('Internal Error: ' . $body['error']['message'], $body['error']['code']);
          default:
            throw new \RuntimeException('Invalid request/response: ' . $body['error']['message'], $body['error']['code']);
        }
      }
    }

    $response->getBody()->rewind();

    return $response;
  }

  /**
   * Get the logger.
   *
   * @return \Psr\Log\LoggerInterface
   */
  public function getLogger() {
    return $this->logger;
  }

  /**
   * Set the logger.
   *
   * @param \Psr\Log\LoggerInterface $logger
   */
  public function setLogger(LoggerInterface $logger) {
    $this->logger = $logger;
  }

  /**
   * Returns the UriFactory.
   *
   * @return \Http\Message\UriFactory
   */
  public function getUriFactory() {
    return $this->uriFactory;
  }

  /**
   * @param \Http\Message\UriFactory $uriFactory
   */
  public function setUriFactory(UriFactory $uriFactory) {
    $this->uriFactory = $uriFactory;
  }

}
