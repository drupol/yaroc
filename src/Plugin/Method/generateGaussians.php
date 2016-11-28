<?php

namespace drupol\Yaroc\Plugin\Method;

use drupol\Yaroc\Plugin\MethodPluginBase;
use drupol\Yaroc\Plugin\MethodPluginInterface;

/**
 * Class generateGaussians.
 *
 * @package drupol\Yaroc\Plugin\Method
 */
class generateGaussians extends MethodPluginBase implements MethodPluginInterface {

  /**
   * {@inheritdoc}
   */
  const METHOD = 'generateGaussians';

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
        'mean' => [
          'value' => NULL,
          'api' => [
            1,
            2,
          ]
        ],
        'standardDeviation' => [
          'value' => NULL,
          'api' => [
            1,
            2,
          ]
        ],
        'significantDigits' => [
          'value' => NULL,
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
      'mean' => 5,
      'standardDeviation' => 2,
      'significantDigits' => 3,
    ];
  }

}