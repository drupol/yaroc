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
   *
   * @return self
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
   * Get a random ID.
   *
   * @return int
   */
  public function getRandomId();

  /**
   * Set the API Version.
   *
   * @param int $apiVersion
   *
   * @return self
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
   * @param \Psr\Http\Message\ResponseInterface $response
   *   The response.
   * @param string $key
   *   The array key to get.
   *
   * @return array|bool
   */
  public function get(ResponseInterface $response, $key = NULL);

  /**
   * Get the content.
   *
   * @param \Psr\Http\Message\ResponseInterface $response
   *   The response.
   *
   * @return array|bool
   */
  public function getContent(ResponseInterface $response);

  /**
   * Get the value for a single header.
   *
   * @param \Psr\Http\Message\ResponseInterface $response
   *   The response.
   * @param string $name
   *   The header name.
   *
   * @return string|null
   */
  public function getHeader(ResponseInterface $response, $name);

}