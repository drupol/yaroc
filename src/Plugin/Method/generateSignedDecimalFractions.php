<?php

namespace drupol\Yaroc\Plugin\Method;

use drupol\Yaroc\Plugin\MethodPluginInterface;

/**
 * Class generateSignedDecimalFractions.
 *
 * @package drupol\Yaroc\Plugin\Method
 */
class generateSignedDecimalFractions extends generateDecimalFractions implements MethodPluginInterface {

  /**
   * {@inheritdoc}
   */
  const METHOD = 'generateSignedDecimalFractions';

}