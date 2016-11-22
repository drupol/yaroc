<?php

namespace drupol\Yaroc\Http\Message\Formatter;

use Http\Message\Formatter\SimpleFormatter;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Normalize a request or a response into a string or an array.
 *
 * @author Joel Wurtz <joel.wurtz@gmail.com>
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class Formatter extends SimpleFormatter implements \Http\Message\Formatter {
  /**
   * {@inheritdoc}
   */
  public function formatRequest(RequestInterface $request)
  {
    return sprintf(
      '%s %s %s %s',
      $request->getMethod(),
      $request->getUri()->__toString(),
      $request->getProtocolVersion(),
      $request->getBody()->getContents()
    );
  }

  /**
   * {@inheritdoc}
   */
  public function formatResponse(ResponseInterface $response)
  {
    return sprintf(
      '%s %s %s %s',
      $response->getStatusCode(),
      $response->getReasonPhrase(),
      $response->getProtocolVersion(),
      $response->getBody()->getContents()
    );
  }
}
