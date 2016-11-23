<?php

namespace drupol\Yaroc;

use drupol\Yaroc\Http\Client;
use drupol\Yaroc\Log\Logger;
use drupol\Yaroc\Plugin\MethodPluginManager;
use Http\Client\HttpClient;
use Psr\Log\LoggerInterface;

/**
 * Class RandomOrgAPIClient
 *
 * @package drupol\Yaroc
 */
class RandomOrgAPI {

  /**
   * The default Random.org endpoint template.
   *
   * @var string;
   */
  protected $endpoint = 'https://api.random.org/json-rpc/%s/invoke';

  /**
   * The Random.org api key.
   *
   * @var string
   */
  protected $apiKey = '';

  /**
   * The HTTP client.
   *
   * @var Client
   */
  protected $httpClient;

  /**
   * The logger.
   *
   * @var \Psr\Log\LoggerInterface
   */
  protected $logger;

  /**
   * The Method plugin manager.
   *
   * @var MethodPluginManager
   */
  protected $methodPluginManager;

  /**
   * The Random.org API version.
   *
   * @var int
   */
  protected $apiVersion = 1;

  /**
   * RandomOrgAPI constructor.
   *
   * @param \Http\Client\HttpClient|NULL $httpClient
   * @param \Psr\Log\LoggerInterface|NULL $logger
   */
  function __construct(HttpClient $httpClient = NULL, LoggerInterface $logger = NULL) {
    $this->setLogger($logger);
    $this->setHttpClient($httpClient);
    $this->setMethodPluginManager(new MethodPluginManager());
    $this->setApiVersion($this->getApiVersion());
    $this->getHttpClient()->setEndpoint($this->getEndpoint());
  }

  /**
   * Set the Random.org endpoint template.
   *
   * @param string $uri
   */
  public function setEndpoint($uri) {
    $this->endpoint = $uri;
  }

  /**
   * Get the Random.org endpoint.
   *
   * @return string
   */
  public function getEndpoint() {
    return sprintf($this->endpoint, $this->getApiVersion());
  }

  /**
   * Set the Method plugin manager.
   *
   * @param MethodPluginManager $methodPluginManager
   */
  public function setMethodPluginManager(MethodPluginManager $methodPluginManager) {
    $this->methodPluginManager = $methodPluginManager;
  }

  /**
   * Return the Method plugin manager.
   *
   * @return \drupol\Yaroc\Plugin\MethodPluginManager
   */
  public function getMethodPluginManager() {
    return $this->methodPluginManager;
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
  public function setLogger(LoggerInterface $logger = NULL) {
    $this->logger = $logger ?: new Logger();
  }

  /**
   * Set the client request.
   *
   * @param HttpClient $httpClient
   *   The client request.
   */
  public function setHttpClient(HttpClient $httpClient = NULL) {
    $this->httpClient = new Client($httpClient, NULL, $this->getLogger());
  }

  /**
   * Get the Http client.
   *
   * @return Client
   */
  public function getHttpClient() {
    return $this->httpClient;
  }

  /**
   * Set the Random.org API Key.
   *
   * @param string $key
   *   The API Key.
   */
  public function setApiKey($key) {
    $this->apiKey = $key;
  }

  /**
   * Get the Random.org API Key.
   *
   * @return string
   *   The API Key.
   */
  public function getApiKey() {
    return $this->apiKey;
  }

  /**
   * Set the API version.
   *
   * @return int
   */
  public function setApiVersion($version) {
    $this->apiVersion = $version;
  }

  /**
   * Get the API version.
   *
   * @return int
   */
  public function getApiVersion() {
    return $this->apiVersion;
  }

  /**
   * Call Random.org API.
   *
   * @param string $method
   *   The method to call.
   * @param array $parameters
   *   The associative array of parameters as defined in the Random.org API.
   *
   * @return array|bool
   *   The response, otherwise FALSE.
   */
  public function call($method, array $parameters = array()) {
    if ($methodPlugin = $this->getMethodPluginManager()->getPlugin($method)) {
      $methodPlugin->setApiVersion($this->getApiVersion());
      $methodPlugin->setApiKey($this->getApiKey());
      $methodPlugin->setParameters($parameters);

      return $this->httpClient->request($methodPlugin);
    }

    return FALSE;
  }

}
