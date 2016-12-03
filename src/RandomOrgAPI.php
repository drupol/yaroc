<?php

namespace drupol\Yaroc;

use drupol\Yaroc\Http\Client;
use drupol\Yaroc\Plugin\MethodPluginInterface;
use drupol\Yaroc\Plugin\MethodPluginManager;
use Http\Client\Common\Plugin;
use Http\Client\HttpClient;
use Http\Message\UriFactory;
use Psr\Http\Message\ResponseInterface;

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
   * The response if any.
   *
   * @var bool|ResponseInterface
   */
  protected $response = FALSE;

  /**
   * @var MethodPluginInterface
   */
  protected $methodPlugin = FALSE;

  /**
   * RandomOrgAPI constructor.
   *
   * @param null|\Http\Client\HttpClient $httpClient
   *   The HTTP client.
   */
  public function __construct(HttpClient $httpClient = NULL) {
    $this->setHttpClient($httpClient);
    $this->setMethodPluginManager(new MethodPluginManager());
    $this->setApiVersion($this->getApiVersion());
  }

  /**
   * Set the Random.org API Key.
   *
   * @param string $key
   *   The API Key.
   *
   * @return self
   */
  public function setApiKey($key) {
    $this->apiKey = $key;

    return $this;
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
   * @param int
   *   The API version.
   *
   * @return self
   */
  public function setApiVersion($version) {
    $this->apiVersion = $version;
    $this->getHttpClient()->setEndpoint($this->getEndpoint());

    return $this;
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
   * Set the Random.org endpoint template.
   *
   * @param string $uri
   *   The URI.
   *
   * @return self
   */
  public function setEndpoint($uri) {
    $this->endpoint = $uri;
    $this->getHttpClient()->setEndpoint($this->getEndpoint());

    return $this;
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
   * Set the client request.
   *
   * @param null|HttpClient $httpClient
   *   The client request.
   * @param null|UriFactory $uriFactory
   *   The URI Factory.
   * @param Plugin[] $plugins
   *   The HTTP plugins.
   *
   * @return self
   */
  public function setHttpClient(HttpClient $httpClient = NULL, UriFactory $uriFactory = NULL, array $plugins = array()) {
    $defaultPlugins = [
      new Plugin\HeaderDefaultsPlugin([
        'Content-Type' => 'application/json',
        'User-Agent' => 'YAROC (http://github.com/drupol/yaroc)',
      ])
    ];

    $plugins = array_merge(array_values($defaultPlugins), array_values($plugins));
    $this->httpClient = new Client($httpClient, $uriFactory, $plugins);
    $this->httpClient->setEndpoint($this->getEndpoint());

    return $this;
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
   * Set the method plugin.
   *
   * @param \drupol\Yaroc\Plugin\MethodPluginInterface|NULL $methodPlugin
   *
   * @return False|self
   *   Return itself, or FALSE otherwise.
   */
  public function setMethodPlugin(MethodPluginInterface $methodPlugin = NULL) {
    $this->methodPlugin = $methodPlugin;

    return $methodPlugin ? $this : FALSE;
  }

  /**
   * Get the method plugin.
   *
   * @return \drupol\Yaroc\Plugin\MethodPluginInterface
   */
  private function getMethodPlugin() {
    return $this->methodPlugin;
  }

  /**
   * Set the Method plugin manager.
   *
   * @param MethodPluginManager $methodPluginManager
   *   The method plugin manager.
   *
   * @return self
   */
  public function setMethodPluginManager(MethodPluginManager $methodPluginManager) {
    $this->methodPluginManager = $methodPluginManager;

    return $this;
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
   * Set the response.
   *
   * @param \Psr\Http\Message\ResponseInterface|NULL $response
   *
   * @return self
   */
  private function setResponse(ResponseInterface $response = NULL) {
    $this->response = $response;

    return $this;
  }

  /**
   * Get the response.
   *
   * @return bool|\Psr\Http\Message\ResponseInterface
   */
  public function getResponse() {
    return $this->response;
  }

  /**
   * @param \drupol\Yaroc\Plugin\MethodPluginInterface $methodPlugin
   *
   * @return ResponseInterface|\Exception
   */
  private function request(MethodPluginInterface $methodPlugin) {
    return $this->httpClient->request($methodPlugin);
  }

  /**
   * Call Random.org API.
   *
   * @param string $method
   *   The method to call.
   * @param array $params
   *   The associative array of params as defined in the Random.org API.
   *
   * @return self
   *   Returns itself.
   */
  public function call($method, array $params = array()) {
    $this->setResponse(NULL);
    $this->setMethodPlugin(NULL);

    $params += ['apiKey' => $this->getApiKey()];

    if ($plugin = $this->getMethodPluginManager()->getPlugin($method, $params)) {
      $this->setMethodPlugin($plugin)->setResponse(
        $this->request(
          $this->getMethodPlugin()->setApiVersion($this->getApiVersion()
          )
        )
      );
    }

    return $this;
  }

  /**
   * Get the result array from the response.
   *
   * @param null|string $key
   *   The key you want to get.
   *
   * @return array|bool
   *   The result array, FALSE otherwise.
   */
  public function get($key = NULL) {
    if ($this->getResponse() && $this->getMethodPlugin()) {
      if ($result = $this->getMethodPlugin()->get($this->getResponse(), $key)) {
        return $result;
      }
    }

    return FALSE;
  }

  /**
   * Get the result array from the response.
   *
   * @param null|string $key
   *   The key you want to get.
   *
   * @return array|bool
   *   The result array, FALSE otherwise.
   */
  public function getFromResult($key = NULL) {
    if ($result = $this->get('result')) {
      if (!is_null($key) && isset($result[$key])) {
        return $result[$key];
      }
      if (is_null($key)) {
        return $result;
      }
    }

    return FALSE;
  }

  /**
   * Get the data from the result array.
   *
   * @return array|bool
   *   The data array, FALSE otherwise.
   */
  public function getData() {
    if ($result = $this->get('result')) {
      if (isset($result['random']) && isset($result['random']['data'])) {
        return $result['random']['data'];
      }
    }

    return FALSE;
  }

}
