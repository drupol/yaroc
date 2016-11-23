<?php

namespace drupol\Yaroc\Plugin\Method;

use drupol\Yaroc\Plugin\MethodPluginBase;
use drupol\Yaroc\Plugin\MethodPluginInterface;
use drupol\Yaroc\Utilities\Utilities;

/**
 * Class generateStrings.
 *
 * @package drupol\Yaroc\Plugin\Method
 */
class generateStrings extends MethodPluginBase implements MethodPluginInterface {

  /**
   * {@inheritdoc}
   */
  const METHOD = 'generateStrings';

  /**
   * {@inheritdoc}
   */
  public function getDefaultParameters() {
    return [
      'n' => NULL,
      'length' => NULL,
      'characters' => Utilities::getDefaultRandomStringCharacters(),
      'replacement' => TRUE,
    ] + parent::getDefaultParameters();
  }


  /**
   * {@inheritdoc}
   */
  public function getTestsParameters() {
    return [
      'n' => 5,
      'length' => 15,
    ];
  }

}