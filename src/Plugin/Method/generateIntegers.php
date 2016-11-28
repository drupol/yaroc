<?php

namespace drupol\Yaroc\Plugin\Method;

use drupol\Yaroc\Plugin\MethodPluginBase;
use drupol\Yaroc\Plugin\MethodPluginInterface;

/**
 * Class generateIntegers.
 *
 * @package drupol\Yaroc\Plugin\Method
 */
class generateIntegers extends MethodPluginBase implements MethodPluginInterface {

  /**
   * {@inheritdoc}
   */
  const METHOD = 'generateIntegers';

  /**
   * {@inheritdoc}
   */
  public function getDefaultParameters() {
    return [
        'apiKey' => [
          'value' => NULL,
          'api' => [
            1,
            2,
          ],
        ],
        'n' => [
          'value' => NULL,
          'api' => [
            1,
            2,
          ]
        ],
        'min' => [
          'value' => NULL,
          'api' => [
            1,
            2,
          ]
        ],
        'max' => [
          'value' => NULL,
          'api' => [
            1,
            2,
          ]
        ],
        'replacement' => [
          'value' => NULL,
          'optional' => TRUE,
          'api' => [
            1,
            2,
          ]
        ],
        'base' => [
          'value' => NULL,
          'optional' => TRUE,
          'api' => [
            1,
            2,
          ]
        ],
      ] + parent::getDefaultParameters();
  }

  /**
   * {@inheritdoc}
   */
  public function getTestsParameters() {
    return [
      'n' => 5,
      'min' => 5,
      'max' => 20,
      'replacement' => TRUE,
      'base' => 16
    ];
  }

}
