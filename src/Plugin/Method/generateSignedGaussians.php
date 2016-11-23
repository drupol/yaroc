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

}