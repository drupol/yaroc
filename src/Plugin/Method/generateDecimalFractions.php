<?php

namespace drupol\Yaroc\Plugin\Method;

use drupol\Yaroc\Plugin\MethodPluginBase;
use drupol\Yaroc\Plugin\MethodPluginInterface;

/**
 * Class generateDecimalFractions.
 *
 * @package drupol\Yaroc\Plugin\Method
 */
class generateDecimalFractions extends MethodPluginBase implements MethodPluginInterface {

  /**
   * {@inheritdoc}
   */
  const METHOD = 'generateDecimalFractions';

  /**
   * {@inheritdoc}
   */
  public function getDefaultParameters() {
    return [
        'apiKey' => [
          'value' => $this->getApiKey(),
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
        'decimalPlaces' => [
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
      ] + parent::getDefaultParameters();
  }

  /**
   * {@inheritdoc}
   */
  public function getTestsParameters() {
    return [
      'n' => 5,
      'decimalPlaces' => 5,
      'replacement' => TRUE,
    ];
  }

}