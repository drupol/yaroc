<?php

namespace drupol\Yaroc\Http;

use drupol\Yaroc\Http\Client\Common\Plugin\LoggerPlugin;
use drupol\Yaroc\Http\Message\Formatter\Formatter;
use drupol\Yaroc\Plugin\MethodPluginInterface;
use Http\Client\Common\HttpMethodsClient;
use Http\Client\Common\Plugin\HeaderDefaultsPlugin;
use Http\Client\Common\PluginClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Discovery\UriFactoryDiscovery;
use Http\Message\UriFactory;
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
   * The logger.
   *
   * @var \Psr\Log\LoggerInterface
   */
  protected $logger;

  /**
   * Client constructor.
   *
   * @param \Http\Client\HttpClient|NULL $httpClient
   * @param \Http\Message\UriFactory|NULL $UriFactory
   * @param \Psr\Log\LoggerInterface|NULL $logger
   */
  function __construct(\Http\Client\HttpClient $httpClient = NULL, UriFactory $UriFactory = NULL, LoggerInterface $logger = NULL) {
    $httpClient = $httpClient ?: HttpClientDiscovery::find();

    $plugins = [
      new HeaderDefaultsPlugin(['Content-Type' => 'application/json']),
      new LoggerPlugin($logger ?: new \drupol\Yaroc\Log\Logger(), new Formatter()),
    ];
    $httpClient = new HttpMethodsClient(new PluginClient($httpClient, $plugins), MessageFactoryDiscovery::find());

    $this->setUriFactory($UriFactory ?: UriFactoryDiscovery::find());
    parent::__construct($httpClient, MessageFactoryDiscovery::find());
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
   * @return \Exception|array|bool
   */
  public function request(MethodPluginInterface $methodPlugin) {
    $result = $this->post($this->getEndpoint(), [], json_encode($methodPlugin->getParameters()));

    if (200 == $result->getStatusCode()) {
      $response = json_decode($result->getBody()->getContents(), TRUE);
      $methodPlugin->validateResponse($response);
      $methodPlugin->alterResponse($response);

      if (isset($response['result'])) {
        return $response['result'];
      }
    }

    return FALSE;
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
