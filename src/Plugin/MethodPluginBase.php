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

    return $this;
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

    $this->setParameters($params);

    return array_filter([
      'jsonrpc' => '2.0',
      'id'      => $this->getRandomId(),
      'method'  => $this->getMethod(),
      'params'  => $params,
    ]);
  }

  /**
   * Get a random ID.
   *
   * @return string
   */
  public function getRandomId() {
    return $this->getMethod() . '_' . mt_rand(1, mt_getrandmax()) . '_' . str_replace('.', '', microtime(TRUE));
  }

  /**
   * {@inheritdoc}
   */
  public function setApiVersion($apiVersion) {
    $this->apiVersion = $apiVersion;

    return $this;
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
