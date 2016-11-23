<?php

namespace drupol\Yaroc\Plugin;

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
   * Alter the response.
   *
   * @param $response
   */
  public function alterResponse(&$response);

  /**
   * Validate the response.
   *
   * @param $response
   *
   * @return mixed
   */
  public function validateResponse($response);

  /**
   * Process JSON-RPC errors
   *
   * @param $error
   * @throws \BadFunctionCallException
   * @throws \InvalidArgumentException
   * @throws \RuntimeException
   */
  public function handleRpcErrors(array $error);

  /**
   * Returns parameters for testing.
   *
   * @return array
   */
  public function getTestsParameters();
}
