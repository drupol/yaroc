<?php

namespace drupol\Yaroc\Plugin\Method;

use drupol\Yaroc\Plugin\MethodPluginInterface;

/**
 * Class generateSignedIntegers.
 *
 * @package drupol\Yaroc\Plugin\Method
 */
class generateSignedIntegers extends generateIntegers implements MethodPluginInterface {

  /**
   * {@inheritdoc}
   */
  const METHOD = 'generateSignedIntegers';

  /**
   * {@inheritdoc}
   */
  public function getDefaultParameters() {
    return [
        'userData' => [
          'value' => NULL,
          'optional' => TRUE,
          'api' => [
            2,
          ],
        ],
      ] + parent::getDefaultParameters();
  }


}