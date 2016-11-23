<?php

namespace drupol\Yaroc\Plugin\Method;

use drupol\Yaroc\Plugin\MethodPluginInterface;

/**
 * Class generateSignedStrings.
 *
 * @package drupol\Yaroc\Plugin\Method
 */
class generateSignedStrings extends generateStrings implements MethodPluginInterface {

  /**
   * {@inheritdoc}
   */
  const METHOD = 'generateSignedStrings';

}