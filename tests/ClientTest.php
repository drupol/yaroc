<?php

namespace drupol\Yaroc\Tests;

use drupol\Yaroc\RandomOrgAPI;
use PHPUnit\Framework\TestCase;
use function bovigo\assert\assert;
use function bovigo\assert\predicate\equals;
use function bovigo\assert\predicate\isInstanceOf;

/**
 * Class ClientTest.
 *
 * @package drupol\yaroc\Tests
 */
class ClientTest extends TestCase {

  /**
   * The client to test.
   *
   * @var RandomOrgAPI
   */
  protected $randomClient;

  public function setUp() {
    parent::setUp();
    $this->randomClient = new RandomOrgAPI();
    $this->randomClient->setApiKey(file_get_contents(__DIR__ . '/../apikey'));
  }

  /**
   * @covers ::setEndpoint()
   * @covers ::getEndpoint()
   */
  public function testEndpoint() {
    $url = 'http://my/url';
    $this->randomClient->getHttpClient()->setEndpoint($url);

    assert($this->randomClient->getHttpClient()->getEndpoint(), equals($url));
    assert($this->randomClient->getHttpClient()->getEndpoint(), isInstanceOf('Psr\Http\Message\UriInterface'));
  }

  /**
   * @covers ::generateIntegers()
   */
  public function testGenerateIntegers() {
    $result = $this->randomClient->call('generateIntegers', ['n' => 5, 'min' => 0, 'max' => 100]);

    assert(count($result['result']['random']['data']), equals(5));
  }

  /**
   * @covers ::generateStrings()
   */
  public function testGenerateStrings() {
    $result = $this->randomClient->call('generateStrings', ['n' => 10, 'length' => 20]);

    assert(count($result['result']['random']['data']), equals(10));
    foreach ($result['result']['random']['data'] as $string) {
      assert(strlen($string), equals(20));
    }
  }
}
