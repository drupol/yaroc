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