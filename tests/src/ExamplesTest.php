<?php

namespace drupol\Yaroc\Tests;

use drupol\Yaroc\Examples\Coin;
use drupol\Yaroc\Examples\Dice;
use drupol\Yaroc\Examples\Pi;

/**
 * Class ExamplesTest.
 *
 * @package drupol\yaroc\Tests
 */
class ExamplesTest extends RandomOrgBase {

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

  /**
   * @covers \drupol\Yaroc\Examples\Pi
   */
  public function testPi() {
    $pi = new Pi();
    $pi->getRandomOrgAPI()->setApiKey($this->randomOrgAPI->getApiKey());

    $pi->run(1);
    foreach (['10', '1000'] as $iteration) {
      $error = abs($pi->get() - pi());
      $this->assertLessThanOrEqual($error, abs($pi->run($iteration)->get() - pi()));
    }



    $this->assertGreaterThanOrEqual(3, $pi->get());
    $this->assertLessThanOrEqual(3.5, $pi->get());
  }

}
