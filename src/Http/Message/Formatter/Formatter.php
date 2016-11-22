<?php

namespace drupol\Yaroc\Http\Message\Formatter;

use Http\Message\Formatter\SimpleFormatter;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Formatter
 *
 * @package drupol\Yaroc\Http\Message\Formatter
 */
class Formatter extends SimpleFormatter implements \Http\Message\Formatter {
  /**
   * {@inheritdoc}
   */
  public function formatRequest(RequestInterface $request)
  {
    $body = $request->getBody()->getContents();
    $request->getBody()->rewind();
    return sprintf(
      '%s %s %s %s',
      $request->getMethod(),
      $request->getUri()->__toString(),
      $request->getProtocolVersion(),
      $body
    );
  }

  /**
   * {@inheritdoc}
   */
  public function formatResponse(ResponseInterface $response)
  {
    $body = $response->getBody()->getContents();
    $response->getBody()->rewind();
    return sprintf(
      '%s %s %s %s',
      $response->getStatusCode(),
      $response->getReasonPhrase(),
      $response->getProtocolVersion(),
      $body
    );
  }
}
