<?php

namespace drupol\Yaroc\Plugin\Method;

use drupol\Yaroc\Plugin\MethodPluginBase;
use drupol\Yaroc\Plugin\MethodPluginInterface;

/**
 * Class generateGaussians.
 *
 * @package drupol\Yaroc\Plugin\Method
 */
class generateGaussians extends MethodPluginBase implements MethodPluginInterface {

  /**
   * {@inheritdoc}
   */
  const METHOD = 'generateGaussians';

  /**
   * {@inheritdoc}
   */
  public function getDefaultParameters() {
    return [
      'n' => NULL,
      'mean' => NULL,
      'standardDeviation' => NULL,
      'significantDigits' => NULL,
    ] + parent::getDefaultParameters();
  }

  /**
   * {@inheritdoc}
   */
  public function getTestsParameters() {
    return [
      'n' => 5,
      'mean' => 5,
      'standardDeviation' => 2,
      'significantDigits' => 3,
    ];
  }

}