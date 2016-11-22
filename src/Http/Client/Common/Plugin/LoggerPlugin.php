<?php

namespace drupol\Yaroc\Http\Client\Common\Plugin;

use Http\Client\Common\Plugin;
use Http\Client\Exception;
use Http\Message\Formatter;
use Http\Message\Formatter\SimpleFormatter;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Logger plugin for YAROC.
 */
class LoggerPlugin implements Plugin
{
  /**
   * Logger to log request / response / exception for a http call.
   *
   * @var LoggerInterface
   */
  private $logger;

  /**
   * Formats a request/response as string.
   *
   * @var Formatter
   */
  private $formatter;

  /**
   * @param LoggerInterface $logger
   */
  public function __construct(LoggerInterface $logger, Formatter $formatter = null)
  {
    $this->logger = $logger;
    $this->formatter = $formatter ?: new SimpleFormatter();
  }

  /**
   * {@inheritdoc}
   */
  public function handleRequest(RequestInterface $request, callable $next, callable $first)
  {
    $this->logger->info(sprintf('Emit request: "%s"', $this->formatter->formatRequest($request)));

    return $next($request)->then(function (ResponseInterface $response) use ($request) {
      $this->logger->info(
        sprintf('Receive response: "%s" for request: "%s"', $this->formatter->formatResponse($response), $this->formatter->formatRequest($request))
      );

      return $response;
    }, function (Exception $exception) use ($request) {
      if ($exception instanceof Exception\HttpException) {
        $this->logger->error(
          sprintf('Error: "%s" with response: "%s" when emitting request: "%s"', $exception->getMessage(), $this->formatter->formatResponse($exception->getResponse()), $this->formatter->formatRequest($request)),
          [
            'request' => $request,
            'response' => $exception->getResponse(),
            'exception' => $exception,
          ]
        );
      } else {
        $this->logger->error(
          sprintf('Error: "%s" when emitting request: "%s"', $exception->getMessage(), $this->formatter->formatRequest($request)),
          [
            'request' => $request,
            'exception' => $exception,
          ]
        );
      }

      throw $exception;
    });
  }
}
