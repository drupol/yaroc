<?php

namespace drupol\Yaroc\Plugin\Method;

use drupol\Yaroc\Plugin\MethodPluginBase;
use drupol\Yaroc\Plugin\MethodPluginInterface;

/**
 * Class getUsage.
 *
 * @package drupol\Yaroc\Plugin\Method
 */
class getUsage extends MethodPluginBase implements MethodPluginInterface {

  /**
   * {@inheritdoc}
   */
  const METHOD = 'getUsage';

  /**
   * {@inheritdoc}
   */
  public function getTestsParameters() {
    return [];
  }

}