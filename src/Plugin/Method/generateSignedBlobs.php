<?php

namespace drupol\Yaroc\Plugin\Method;

use drupol\Yaroc\Plugin\MethodPluginInterface;

/**
 * Class generateSignedBlobs.
 *
 * @package drupol\Yaroc\Plugin\Method
 */
class generateSignedBlobs extends generateBlobs implements MethodPluginInterface {

  /**
   * {@inheritdoc}
   */
  const METHOD = 'generateSignedBlobs';

}