<?php

namespace drupol\Yaroc\Plugin\Method;

use drupol\Yaroc\Plugin\MethodPluginBase;
use drupol\Yaroc\Plugin\MethodPluginInterface;

/**
 * Class generateDecimalFractions.
 *
 * @package drupol\Yaroc\Plugin\Method
 */
class generateDecimalFractions extends MethodPluginBase implements MethodPluginInterface {

  /**
   * {@inheritdoc}
   */
  const METHOD = 'generateDecimalFractions';

  /**
   * {@inheritdoc}
   */
  public function getDefaultParameters() {
    return [
      'n' => NULL,
      'decimalPlaces' => NULL,
      'replacement' => TRUE,
    ] + parent::getDefaultParameters();
  }

  /**
   * {@inheritdoc}
   */
  public function getTestsParameters() {
    return [
      'n' => 5,
      'decimalPlaces' => 5,
      'replacement' => TRUE,
    ];
  }

}