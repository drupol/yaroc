<?php

namespace drupol\Yaroc\Plugin;

use Psr\Http\Message\ResponseInterface;

abstract class MethodPluginBase implements MethodPluginInterface {

  /**
   * The method name.
   */
  const METHOD = 'BASE';

  /**
   * The parameters.
   *
   * @var array
   */
  protected $parameters;

  /**
   * The API Key.
   *
   * @var string
   */
  protected $apiKey;

  /**
   * The API Version.
   *
   * @var int
   */
  protected $apiVersion;

  /**
   * {@inheritdoc}
   */
  public function getMethod() {
    return $this::METHOD;
  }

  /**
   * {@inheritdoc}
   */
  public function setParameters(array $parameters = array()) {
    $this->parameters = $parameters;
  }

  /**
   * {@inheritdoc}
   */
  public function getDefaultParameters() {
    return [];
  }

  /**
   * {@inheritdoc}
   */
  public function getParameters() {
    $defaultParameters = $this->getDefaultParameters();

    $params = [];
    foreach ($this->getDefaultParameters() as $key => $parameter) {
      if (in_array($this->getApiVersion(), (array) $defaultParameters[$key]['api'])) {
        if (!is_null($parameter['value'])) {
          $params[$key] = $parameter['value'];
        }
      }
    }

    foreach ((array) $this->parameters as $key => $value) {
      if (array_key_exists($key, $defaultParameters)) {
        if (in_array($this->getApiVersion(), (array) $defaultParameters[$key]['api'])) {
          $params[$key] = $value;
        }
      }
    }

    return array_filter([
      'jsonrpc' => '2.0',
      'id'      => mt_rand(1, 999999),
      'method'  => $this->getMethod(),
      'params'  => $params,
    ]);
  }

  /**
   * {@inheritdoc}
   */
  public function setApiKey($apiKey) {
    $this->apiKey = $apiKey;
  }

  /**
   * {@inheritdoc}
   */
  public function getApiKey() {
    return $this->apiKey;
  }

  /**
   * {@inheritdoc}
   */
  public function setApiVersion($apiVersion) {
    $this->apiVersion = $apiVersion;
  }

  /**
   * {@inheritdoc}
   */
  public function getApiVersion() {
    return $this->apiVersion;
  }

  /**
   * {@inheritdoc}
   */
  public function getResult(ResponseInterface $response) {
    $body = json_decode($response->getBody(), TRUE);
    $response->getBody()->rewind();
    return $body['result'];
  }

}
