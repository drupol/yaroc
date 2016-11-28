<?php

namespace drupol\Yaroc\Plugin\Method;

use drupol\Yaroc\Plugin\MethodPluginBase;
use drupol\Yaroc\Plugin\MethodPluginInterface;
use drupol\Yaroc\Utilities\Utilities;

/**
 * Class generateStrings.
 *
 * @package drupol\Yaroc\Plugin\Method
 */
class generateStrings extends MethodPluginBase implements MethodPluginInterface {

  /**
   * {@inheritdoc}
   */
  const METHOD = 'generateStrings';

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
        'length' => [
          'value' => NULL,
          'api' => [
            1,
            2,
          ]
        ],
        'characters' => [
          'value' => Utilities::getDefaultRandomStringCharacters(),
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
      'length' => 15,
    ];
  }

}