<?php

namespace drupol\Yaroc\Examples;

/**
 * Class Location.
 *
 * @package drupol\Yaroc\Examples
 */
class Location extends BaseExample {

  /**
   * @var double[]
   */
  protected $coordinates;

  /**
   * Find random location.
   *
   * @return self
   */
  public function find() {
    $result = $this->randomOrgAPI->call('generateDecimalFractions', ['n' => 3, 'decimalPlaces' => 10])
      ->getData();

    $this->coordinates = [
      'x' => rad2deg($result[0] * 2 * pi() - pi()),
      'y' => rad2deg(pi()/2 - acos($result[1] * 2 - 1)),
      'z' => $result[2] * 1000,
    ];

    return $this;
  }

  /**
   * Get the coordinates.
   *
   * @return double[]
   */
  public function getCoordinates() {
    return $this->coordinates;
  }

}
