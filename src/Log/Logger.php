<?php

namespace drupol\Yaroc\Log;

use Monolog\Handler\StreamHandler;
use Psr\Log\LoggerInterface;

/**
 * Class Logger
 *
 * @package drupol\Yaroc\Log
 */
class Logger extends \Monolog\Logger implements LoggerInterface {

  function __construct(LoggerInterface $logger = NULL) {
    parent::__construct('yaroc');
    $this->setHandlers([
      new StreamHandler('php://memory', \Monolog\Logger::DEBUG),
    ]);
   }

}
