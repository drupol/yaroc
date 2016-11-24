<?php

namespace drupol\Yaroc\Tests;

use drupol\Yaroc\Plugin\MethodPluginManager;
use drupol\Yaroc\RandomOrgAPI;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use function bovigo\assert\assert;
use function bovigo\assert\predicate\equals;
use function bovigo\assert\predicate\isInstanceOf;

/**
 * Class RandomOrgAPITest.
 *
 * @package drupol\yaroc\Tests
 */
class RandomOrgAPITest extends TestCase {

  /**
   * The client to test.
   *
   * @var RandomOrgAPI
   */
  protected $randomClient;

  /**
   * @var MethodPluginManager
   */
  protected $methodPluginManager;

  public function setUp() {
    parent::setUp();

    $this->randomClient = new RandomOrgAPI();
  }

  /**
   * @covers \drupol\Yaroc\RandomOrgAPI::setEndpoint()
   * @covers \drupol\Yaroc\RandomOrgAPI::getEndpoint()
   */
  public function testEndpoint() {
    $url = 'http://my/url/%s';
    $this->randomClient->setApiVersion(1);
    $this->randomClient->setEndpoint($url);

    $this->assertEquals('http://my/url/1', $this->randomClient->getEndpoint());
    $this->assertInstanceOf('\Psr\Http\Message\UriInterface', $this->randomClient->getHttpClient()->getEndpoint());
  }

  /**
   * @covers \drupol\Yaroc\RandomOrgAPI::setApiVersion()
   * @covers \drupol\Yaroc\RandomOrgAPI::getApiVersion()
   */
  public function testApiVersion() {
    $this->randomClient->setApiVersion(3);
    $this->assertEquals(3, $this->randomClient->getApiVersion());
  }

  /**
   * @covers \drupol\Yaroc\RandomOrgAPI::call()
   */
  public function testUnknownMethod() {
    $result = $this->randomClient->call('izumi', ['n' => 5, 'min' => 0, 'max' => 100]);

    $this->assertFalse($result);
  }

  /**
   * @covers \drupol\Yaroc\RandomOrgAPI::setApiKey()
   * @covers \drupol\Yaroc\RandomOrgAPI::getApiKey()
   */
  public function testSetApiKey() {
    $apikey = 'IamBroggyAndIKnowIt';
    $this->randomClient->setApiKey($apikey);

    $this->assertEquals($apikey, $this->randomClient->getApiKey());
  }

  /**
   * @covers \drupol\Yaroc\RandomOrgAPI::getHttpClient()
   * @covers \drupol\Yaroc\RandomOrgAPI::setHttpClient()
   */
  public function testHttpClient() {
    $this->assertInstanceOf('\drupol\Yaroc\Http\Client', $this->randomClient->getHttpClient());
  }

  /**
   * @covers \drupol\Yaroc\RandomOrgAPI::setMethodPluginManager()
   * @covers \drupol\Yaroc\RandomOrgAPI::getMethodPluginManager()
   */
  public function testMethodPluginManager() {
    $this->assertInstanceOf('\drupol\Yaroc\Plugin\MethodPluginManager', $this->randomClient->getMethodPluginManager());
  }

  /**
   * @covers \drupol\Yaroc\RandomOrgAPI::call()
   *
   * @expectedException \RuntimeException
   */
  public function testWrongParameters() {
    $method = 'generateIntegers';
    $params = [
      'n' => -5,
      'min' => 0,
      'max' => 5,
    ];
    $this->randomClient->call($method, $params);
  }

  /**
   * @covers \drupol\Yaroc\RandomOrgAPI::call()
   */
  public function testInvalidMethod() {
    // Unknown method.
    $method = 'izumi';
    $params = [
      'n' => 1,
      'min' => 0,
      'max' => 5,
    ];
    $this->assertFalse($this->randomClient->call($method, $params));
  }

}
