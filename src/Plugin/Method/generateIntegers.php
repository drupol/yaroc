<?php

namespace drupol\Yaroc\Plugin\Method;

use drupol\Yaroc\Plugin\MethodPluginBase;
use drupol\Yaroc\Plugin\MethodPluginInterface;

/**
 * Class generateIntegers.
 *
 * @package drupol\Yaroc\Plugin\Method
 */
class generateIntegers extends MethodPluginBase implements MethodPluginInterface {

  /**
   * {@inheritdoc}
   */
  const METHOD = 'generateIntegers';

  /**
   * {@inheritdoc}
   */
  public function getDefaultParameters() {
    return [
      'n' => NULL,
      'min' => NULL,
      'max' => NULL,
      'replacement' => TRUE,
      'base' => 10,
    ] + parent::getDefaultParameters();
  }

  /**
   * {@inheritdoc}
   */
  public function getTestsParameters() {
    return [
      'n' => 5,
      'min' => 5,
      'max' => 20,
      'replacement' => TRUE,
      'base' => 16
    ];
  }

}
