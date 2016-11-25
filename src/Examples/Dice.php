<?php

namespace drupol\Yaroc\Examples;

/**
 * Class Dice.
 *
 * @package drupol\Yaroc\Examples
 */
class Dice extends BaseExample {

  /**
   * @return array
   */
  function roll() {
    $result = $this->randomOrgAPI->call('generateIntegers', ['n' => 2, 'min' => 1, 'max' => 6])
      ->getResult();
    return $result['random']['data'];
  }

}
