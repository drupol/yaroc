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

    $temporary_key = '00000000-0000-0000-0000-000000000000';
    if (file_exists('./apikey') && $file_key = file_get_contents('./apikey')) {
      $key = $file_key;
    } else {
      $key = $temporary_key;
    }

    $this->randomOrgAPI->setApiKey($key);
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
