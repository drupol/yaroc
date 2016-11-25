<?php

namespace drupol\Yaroc\Examples;

/**
 * Class Coin.
 *
 * @package drupol\Yaroc\Examples
 */
class Coin extends BaseExample {

  /**
   * @var string
   */
  protected $face;

  /**
   * @return array
   */
  function flip() {
    $result = $this->randomOrgAPI->call('generateIntegers', ['n' => 1, 'min' => 0, 'max' => 1])
      ->getResult();

    $this->face = (1 == $result['random']['data'][0]) ? 'tails' : 'heads';

    return $this->face;
  }

  /**
   * @return string
   */
  function getFace() {
    return $this->face;
  }

}
