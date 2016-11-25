<?php

namespace drupol\Yaroc\Plugin;

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
    return [
      'apiKey' => $this->getApiKey()
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getParameters() {
    $apiArgs = $this->getDefaultParameters();

    foreach ((array) $this->parameters as $key => $value) {
      if (array_key_exists($key, $apiArgs)) {
        $apiArgs[$key] = $value;
      }
    }

    return [
      'jsonrpc' => '2.0',
      'id'      => mt_rand(1, 999999),
      'method'  => $this::METHOD,
      'params'  => $apiArgs,
    ];
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

}
