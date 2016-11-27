<?php

namespace drupol\Yaroc\Plugin\Method;

use drupol\Yaroc\Plugin\MethodPluginInterface;

/**
 * Class generateSignedGaussians.
 *
 * @package drupol\Yaroc\Plugin\Method
 */
class generateSignedGaussians extends generateGaussians implements MethodPluginInterface {

  /**
   * {@inheritdoc}
   */
  const METHOD = 'generateSignedGaussians';

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