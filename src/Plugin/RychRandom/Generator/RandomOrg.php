<?php

namespace drupol\Yaroc\Plugin\RychRandom\Generator;

use drupol\Yaroc\RandomOrgAPI;
use Rych\Random\Generator\GeneratorInterface;

/**
 * The Random.Org Generator.
 *
 * @codeCoverageIgnore
 */
class RandomOrg implements GeneratorInterface {

  /**
   * The Random.Org API.
   *
   * @var RandomOrgAPI
   */
  protected $randomOrgAPI;

  /**
   * RandomOrg constructor.
   */
  public function __construct() {
    $this->randomOrgAPI = new RandomOrgAPI();
    $this->randomOrgAPI->setApiKey(file_get_contents('./apikey'));
  }

  /**
   * {@inheritdoc}
   */
  public static function getPriority() {
    return GeneratorInterface::PRIORITY_HIGH;
  }

  /**
   * {@inheritdoc}
   */
  public static function isSupported() {
    return class_exists('RandomOrgAPI');
  }

  /**
   * {@inheritdoc}
   */
  public function generate($size) {
    $result = $this->randomOrgAPI->call('generateStrings', ['n' => 1, 'length' => $size])
      ->getData();

    return $result[0];
  }

}
