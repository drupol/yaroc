<?php

namespace drupol\Yaroc\Examples;

/**
 * Class Pi.
 *
 * @package drupol\Yaroc\Examples
 */
class Pi extends BaseExample {

  /**
   * @var float
   */
  protected $estimation;

  /**
   * @return self
   */
  function run($n = 1000) {
    $numbers = $this->randomOrgAPI->call('generateDecimalFractions', ['n' => $n * 2, 'decimalPlaces' => 6]);

    $inside = 0;
    for ($i = 0; $i < $n; $i++) {
      $x = $numbers['result']['random']['data'][$i];
      $y = $numbers['result']['random']['data'][$i+1];

      if (sqrt($x*$x + $y*$y) <= 1) {
        $inside++;
      }
    }

    $this->estimation = 4 * $inside/$n;

    return $this;
  }

  public function get() {
    return $this->estimation;
  }

}