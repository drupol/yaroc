<?php

namespace drupol\Yaroc\Plugin\Method;

use drupol\Yaroc\Plugin\MethodPluginInterface;

/**
 * Class generateSignedUUIDs.
 *
 * @package drupol\Yaroc\Plugin\Method
 */
class generateSignedUUIDs extends generateUUIDs implements MethodPluginInterface {

  /**
   * {@inheritdoc}
   */
  const METHOD = 'generateSignedUUIDs';

}