<?php

/**
 * The Random.Org Source
 *
 * PHP version 5.3
 *
 * @category   PHPCryptLib
 * @package    Random
 * @subpackage Source
 *
 * @author     Pol Dellaiera <pol.dellaiera@protonmail.com>
 * @copyright  2011 The Authors
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 *
 * @version    Build @@version@@
 */
namespace drupol\Yaroc\Plugin\RandomLib\Source;

use drupol\Yaroc\RandomOrgAPI;
use SecurityLib\Strength;

/**
 * The Random.Org Source
 *
 * @category   PHPCryptLib
 * @package    Random
 * @subpackage Source
 *
 * @author     Pol Dellaiera <pol.dellaiera@protonmail.com>
 * @codeCoverageIgnore
 */
class RandomOrg extends \RandomLib\AbstractSource {

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
   * Return an instance of Strength indicating the strength of the source
   *
   * @return \SecurityLib\Strength An instance of one of the strength classes
   */
  public static function getStrength() {
    return new Strength(Strength::HIGH);
  }

  /**
   * If the source is currently available.
   * Reasons might be because the library is not installed
   *
   * @return bool
   */
  public static function isSupported() {
    return class_exists('RandomOrgAPI');
  }

  /**
   * Generate a random string of the specified size
   *
   * @param int $size The size of the requested random string
   *
   * @return string A string of the requested size
   */
  public function generate($size)
  {
    $result = $this->randomOrgAPI->call('generateStrings', ['n' => 1, 'length' => $size])
      ->getResult();

    return $result['random']['data'][0];
  }

}
