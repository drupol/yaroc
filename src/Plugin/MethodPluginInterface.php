<?php

namespace drupol\Yaroc\Plugin;

use Psr\Http\Message\ResponseInterface;

interface MethodPluginInterface {

  /**
   * Get the API Method name.
   *
   * @return string
   */
  public function getMethod();

  /**
   * Set the method parameters.
   *
   * @param array $parameters
   *   The method parameters.
   */
  public function setParameters(array $parameters = array());

  /**
   * Get the default parameters.
   *
   * @return array
   *   The default parameters.
   */
  public function getDefaultParameters();

  /**
   * Get the method's parameters.
   *
   * @return array
   *   The method's parameters.
   */
  public function getParameters();

  /**
   * Set the API Key.
   *
   * @param string $apiKey
   */
  public function setApiKey($apiKey);

  /**
   * Get the API Key.
   *
   * @return string
   */
  public function getApiKey();

  /**
   * Set the API Version.
   *
   * @param int $apiVersion
   */
  public function setApiVersion($apiVersion);

  /**
   * Get the API Version.
   *
   * @return int
   */
  public function getApiVersion();

  /**
   * Returns parameters for testing.
   *
   * @return array
   */
  public function getTestsParameters();

  /**
   * Return the result array from the response.
   *
   * @param \Psr\Http\Message\ResponseInterface|NULL $response
   *
   * @return array|bool
   */
  public function getResult(ResponseInterface $response = NULL);

}