<?php

namespace drupol\Yaroc\Http;

use drupol\Yaroc\Plugin\MethodPluginInterface;
use Http\Client\Common\HttpMethodsClient;
use Http\Client\Common\Plugin;
use Http\Client\Common\PluginClient;
use Http\Client\Exception\NetworkException;
use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Discovery\UriFactoryDiscovery;
use Http\Message\UriFactory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

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
   * @param Plugin[] $plugins
   */
  public function __construct(HttpClient $httpClient = NULL, UriFactory $uriFactory = NULL, array $plugins = array()) {
    $httpClient = $httpClient ?: HttpClientDiscovery::find();
    $httpClient = new HttpMethodsClient(new PluginClient($httpClient, $plugins), MessageFactoryDiscovery::find());
    $this->setUriFactory($uriFactory ?: UriFactoryDiscovery::find());

    parent::__construct($httpClient, MessageFactoryDiscovery::find());
  }

  /**
   * Set the Random.org endpoint.
   *
   * @param string $uri
   *
   * @return self
   */
  public function setEndpoint($uri) {
    $this->endpoint = $this->getUriFactory()->createUri($uri);

    return $this;
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
   * @param \Http\Message\UriFactory $uriFactory
   *
   * @return self
   */
  public function setUriFactory(UriFactory $uriFactory) {
    $this->uriFactory = $uriFactory;

    return $this;
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

}
