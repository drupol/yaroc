<?php

namespace drupol\Yaroc\Examples;

use drupol\Yaroc\RandomOrgAPI;

abstract class BaseExample {

  /**
   * The Random.org API bridge.
   *
   * @var \drupol\Yaroc\RandomOrgAPI
   */
  protected $randomOrgAPI;

  /**
   * BaseExample constructor.
   */
  public function __construct() {
    $this->randomOrgAPI = new RandomOrgAPI();
  }

  /**
   * Get the Random.org API bridge.
   *
   * @return \drupol\Yaroc\RandomOrgAPI
   */
  public function getRandomOrgAPI() {
    return $this->randomOrgAPI;
  }

}
