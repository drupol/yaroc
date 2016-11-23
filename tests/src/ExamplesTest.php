<?php

namespace drupol\Yaroc\Tests;

use drupol\Yaroc\Examples\Coin;
use drupol\Yaroc\Examples\Dice;
use drupol\Yaroc\RandomOrgAPI;
use PHPUnit\Framework\TestCase;

/**
 * Class ExamplesTest.
 *
 * @package drupol\yaroc\Tests
 */
class ExamplesTest extends TestCase {

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
    if (file_exists(__DIR__ . '/../apikey') && $file_key = file_get_contents(__DIR__ . '/../apikey')) {
      $key = $file_key;
    } else {
      $key = $temporary_key;
    }

    $this->randomOrgAPI->setApiKey($key);
  }

  /**
   * @covers \drupol\Yaroc\Examples\Dice
   */
  public function testDice() {
    $dice = new Dice();
    $dice->getRandomOrgAPI()->setApiKey($this->randomOrgAPI->getApiKey());

    $this->assertCount(2, $dice->roll());
    $this->assertGreaterThanOrEqual(1, $dice->roll()[0]);
    $this->assertLessThanOrEqual(6, $dice->roll()[0]);
    $this->assertGreaterThanOrEqual(1, $dice->roll()[1]);
    $this->assertLessThanOrEqual(6, $dice->roll()[1]);
  }

  /**
   * @covers \drupol\Yaroc\Examples\Coin
   */
  public function testCoin() {
   $coin = new Coin();
    $coin->getRandomOrgAPI()->setApiKey($this->randomOrgAPI->getApiKey());

    $face = $coin->flip();
    $this->assertContains($coin->getFace(), array('tails', 'heads'));

    $i = 0;
    do {
      $i++;
      $this->assertContains($coin->getFace(), array('tails', 'heads'));
    } while ($face == $coin->flip() && $i <= 50);
    $this->assertLessThanOrEqual(50, $i);
  }

}
