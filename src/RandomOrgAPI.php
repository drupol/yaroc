<?php

namespace drupol\Yaroc;

use drupol\Yaroc\Http\Client;
use drupol\Yaroc\Log\Logger;
use drupol\Yaroc\Utilities\Utilities;
use Http\Client\HttpClient;
use Psr\Log\LoggerInterface;

/**
 * Class RandomOrgAPIClient
 *
 * @package drupol\Yaroc
 */
class RandomOrgAPI {

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
   * RandomOrgAPI constructor.
   *
   * @param \Http\Client\HttpClient|NULL $httpClient
   * @param \Psr\Log\LoggerInterface|NULL $logger
   */
  function __construct(HttpClient $httpClient = NULL, LoggerInterface $logger = NULL) {
    $this->setLogger($logger);
    $this->setHttpClient($httpClient);
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
   * @return \Http\Client\Common\HttpMethodsClient
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
   * @param $method
   * @param $params
   *
   * @return array|bool
   */
  private function send($method, array $params = array()) {
    return $this->httpClient->request($this->createBody($method, $params));
  }

  /**
   * Create a new request.
   *
   * @param $method
   * @param $params
   *
   * @return array
   */
  private function createBody($method, $params) {
    $body = [
      'jsonrpc' => '2.0',
      'id'      => mt_rand(1, 999999),
      'method'  => $method,
      'params'  => $params,
    ];

    return $body;
  }

  /**
   * Get the API parameters definitions.
   *
   * @param string|null $method
   *   The method name.
   *
   * @return bool|array
   *   If $method exists returns the appropriate definitions, if it doesn't
   *   exists, it returns FALSE, if method is NULL, returns the complete array.
   */
  protected function getAPI($method = NULL) {
    $api = [
      'generateIntegers' => [
        'apiKey' => $this->getApiKey(),
        'n' => NULL,
        'min' => NULL,
        'max' => NULL,
        'replacement' => TRUE,
        'base' => 10,
      ],
      'generateDecimalFractions' => [
        'apiKey' => $this->getApiKey(),
        'n' => NULL,
        'decimalPlaces' => NULL,
        'replacement' => TRUE,
      ],
      'generateGaussians' => [
        'apiKey' => $this->getApiKey(),
        'n' => NULL,
        'mean' => NULL,
        'standardDeviation' => NULL,
        'significantDigits' => NULL,
      ],
      'generateStrings' => [
        'apiKey' => $this->getApiKey(),
        'n' => NULL,
        'length' => NULL,
        'characters' => Utilities::getDefaultRandomStringCharacters(),
        'replacement' => TRUE,
      ],
      'generateUUIDs' => [
        'apiKey' => $this->getApiKey(),
        'n' => NULL,
      ],
      'generateBlobs' => [
        'apiKey' => $this->getApiKey(),
        'n' => NULL,
        'size' => NULL,
        'format' => 'base64',
      ],
      'getUsage' => [
        'apiKey' => $this->getApiKey(),
      ],
      'generateSignedIntegers' => [
        'apiKey' => $this->getApiKey(),
        'n' => NULL,
        'min' => NULL,
        'max' => NULL,
        'replacement' => TRUE,
        'base' => 10,
      ],
      'generateSignedDecimalFractions' => [
        'apiKey' => $this->getApiKey(),
        'n' => NULL,
        'decimalPlaces' => NULL,
        'replacement' => TRUE,
      ],
      'generateSignedGaussians' => [
        'apiKey' => $this->getApiKey(),
        'n' => NULL,
        'mean' => NULL,
        'standardDeviation' => NULL,
        'significantDigits' => NULL,
      ],
      'generateSignedStrings' => [
        'apiKey' => $this->getApiKey(),
        'n' => NULL,
        'length' => NULL,
        'characters' => Utilities::getDefaultRandomStringCharacters(),
        'replacement' => TRUE,
      ],
      'generateSignedUUIDs' => [
        'apiKey' => $this->getApiKey(),
        'n' => NULL,
      ],
      'generateSignedBlobs' => [
        'apiKey' => $this->getApiKey(),
        'n' => NULL,
        'size' => NULL,
        'format' => 'base64',
      ],
      'verifySignature' => [
        'random' => NULL,
        'signature' => NULL,
      ],
    ];

    if (is_null($method)) {
      return $api;
    }

    return isset($api[$method]) ? $api[$method] : FALSE;
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
    if (!($apiArgs = $this->getAPI($method))) {
      return FALSE;
    }

    foreach ($parameters as $key => $value) {
      if (array_key_exists($key, $apiArgs)) {
        $apiArgs[$key] = $value;
      }
    }

    return $this->send($method, $apiArgs);
  }

}
