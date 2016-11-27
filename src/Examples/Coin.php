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
   * Flip the coin.
   *
   * @return self
   */
  public function flip() {
    $result = $this->randomOrgAPI->call('generateIntegers', ['n' => 1, 'min' => 0, 'max' => 1])
      ->getResult();

    $this->face = (1 == $result['random']['data'][0]) ? 'tails' : 'heads';

    return $this;
  }

  /**
   * Get the coin face.
   *
   * @return string
   */
  public function getFace() {
    return $this->face;
  }

}
