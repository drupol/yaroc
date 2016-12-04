<?php

namespace drupol\Yaroc\Tests;

use drupol\Yaroc\Examples\Coin;
use drupol\Yaroc\Examples\Dice;
use drupol\Yaroc\Examples\Location;
use drupol\Yaroc\Examples\Pi;
use drupol\Yaroc\Examples\Time;

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

    $face = $coin->flip()->getFace();
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

    $pi->run(2);
    $error = abs($pi->get() - pi());
    $this->assertLessThanOrEqual($error, abs($pi->run(1000)->get() - pi()));

    $this->assertGreaterThanOrEqual(3, $pi->get());
    $this->assertLessThanOrEqual(3.5, $pi->get());
  }

  /**
   * @covers \drupol\Yaroc\Examples\Location
   */
  public function testLocation() {
    $location = new Location();
    $location->getRandomOrgAPI()->setApiKey($this->randomOrgAPI->getApiKey());

    $coordinates = $location->find()->getCoordinates();

    $this->assertGreaterThanOrEqual(-180, $coordinates['x']);
    $this->assertLessThanOrEqual(180, $coordinates['x']);

    $this->assertGreaterThanOrEqual(-90, $coordinates['y']);
    $this->assertLessThanOrEqual(90, $coordinates['y']);

    $this->assertGreaterThanOrEqual(0, $coordinates['z']);
  }

  /**
   * @covers \drupol\Yaroc\Examples\Time
   */
  public function testTime() {
    $time = new Time();
    $time->getRandomOrgAPI()->setApiKey($this->randomOrgAPI->getApiKey());

    $time = $time->find()->get();

    $this->assertGreaterThanOrEqual(0, $time['h']);
    $this->assertLessThanOrEqual(23, $time['h']);

    $this->assertGreaterThanOrEqual(0, $time['m']);
    $this->assertLessThanOrEqual(59, $time['m']);

    $this->assertGreaterThanOrEqual(0, $time['s']);
    $this->assertLessThanOrEqual(59, $time['s']);
  }

}
