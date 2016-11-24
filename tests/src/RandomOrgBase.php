<?php

namespace drupol\Yaroc\Tests;

use drupol\Yaroc\RandomOrgAPI;
use PHPUnit\Framework\TestCase;

/**
 * Class RandomOrgBase.
 *
 * @package drupol\yaroc\Tests
 */
class RandomOrgBase extends TestCase {

  /**
   * The client to test.
   *
   * @var RandomOrgAPI
   */
  protected $randomOrgAPI;

  public function setUp() {
    parent::setUp();

    $this->randomOrgAPI = new RandomOrgAPI();

    $temporary_key = '00000000-0000-0000-0000-000000000000';
    if (file_exists('./apikey') && $file_key = file_get_contents('./apikey')) {
      $key = $file_key;
    } else {
      $key = $temporary_key;
    }

    $this->randomOrgAPI->setApiKey($key);
  }

}
