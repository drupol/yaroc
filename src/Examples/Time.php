<?php

namespace drupol\Yaroc\Examples;

/**
 * Class Time.
 *
 * @package drupol\Yaroc\Examples
 */
class Time extends BaseExample {

  /**
   * @var integer[]
   */
  protected $time;

  /**
   * Find random time.
   *
   * @return self
   */
  public function find() {
    $hours = $this->randomOrgAPI->call('generateIntegers', ['n' => 1, 'min' => 0, 'max' => 23])->getData();
    $minutesSeconds = $this->randomOrgAPI->call('generateIntegers', ['n' => 2, 'min' => 0, 'max' => 59])->getData();

    $this->time = [
      'h' => $hours[0],
      'm' => $minutesSeconds[0],
      's' => $minutesSeconds[1],
    ];

    return $this;
  }

  /**
   * Get the time.
   *
   * @return integer[]
   */
  public function get() {
    return $this->time;
  }

}
