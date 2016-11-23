<?php

namespace drupol\Yaroc\Plugin\Method;

use drupol\Yaroc\Plugin\MethodPluginBase;
use drupol\Yaroc\Plugin\MethodPluginInterface;

/**
 * Class generateUUIDs.
 *
 * @package drupol\Yaroc\Plugin\Method
 */
class generateUUIDs extends MethodPluginBase implements MethodPluginInterface {

  /**
   * {@inheritdoc}
   */
  const METHOD = 'generateUUIDs';

  /**
   * {@inheritdoc}
   */
  public function getDefaultParameters() {
    return [
      'n' => NULL,
    ] + parent::getDefaultParameters();
  }

  /**
   * {@inheritdoc}
   */
  public function getTestsParameters() {
    return [
      'n' => 5,
    ];
  }

}