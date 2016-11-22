<?php

namespace drupol\Yaroc\Http;

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
  protected $endpoint = 'https://api.random.org/json-rpc/1/invoke';

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

  function __construct(\Http\Client\HttpClient $httpClient = NULL, UriFactory $UriFactory = NULL, LoggerInterface $logger = NULL) {
    $httpClient = $httpClient ?: HttpClientDiscovery::find();

    $plugins = [
      new HeaderDefaultsPlugin(['Content-Type' => 'application/json']),
    ];
    $httpClient = new HttpMethodsClient(new PluginClient($httpClient, $plugins), MessageFactoryDiscovery::find());

    $this->setUriFactory($UriFactory ?: UriFactoryDiscovery::find());
    $this->setLogger($logger ?: new \drupol\Yaroc\Log\Logger());
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
   * @param $body
   *
   * @return array|bool
   */
  public function request($body) {
    $this->log()->debug(sprintf("[%s] [%s]", 'POST', $this->getEndpoint()), $body);
    $result = $this->post($this->getEndpoint(), [], json_encode($body));

    if (200 == $result->getStatusCode()) {
      $this->log()->debug('Request has succeeded.');
      return json_decode($result->getBody()->getContents(), TRUE);
    } else {
      $this->log()->debug('Request has failed.');
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

  /**
   * @return \Psr\Log\LoggerInterface
   */
  private function log() {
    return $this->getLogger();
  }

}
