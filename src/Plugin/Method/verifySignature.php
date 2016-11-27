<?php

namespace drupol\Yaroc\Plugin\Method;

use drupol\Yaroc\Plugin\MethodPluginBase;
use drupol\Yaroc\Plugin\MethodPluginInterface;

/**
 * Class verifySignature.
 *
 * @package drupol\Yaroc\Plugin\Method
 */
class verifySignature extends MethodPluginBase implements MethodPluginInterface {

  /**
   * {@inheritdoc}
   */
  const METHOD = 'verifySignature';

  /**
   * {@inheritdoc}
   */
  public function getDefaultParameters() {
    return [
      'random' => [
        'value' => NULL,
        'api' => [
          1,
          2,
        ],
      ],
      'signature' => [
        'value' => NULL,
        'api' => [
          1,
          2,
        ],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getTestsParameters() {
    return [
      'random' => '',
      'signature' => ''
    ];
  }

}