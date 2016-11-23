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

    assert($this->randomClient->getEndpoint(), equals('http://my/url/1'));
    assert($this->randomClient->getHttpClient()->getEndpoint(), isInstanceOf('Psr\Http\Message\UriInterface'));
  }

  /**
   * @covers \drupol\Yaroc\RandomOrgAPI::setApiVersion()
   * @covers \drupol\Yaroc\RandomOrgAPI::getApiVersion()
   */
  public function testApiVersion() {
    $this->randomClient->setApiVersion(3);
    assert($this->randomClient->getApiVersion(), equals(3));
  }

  /**
   * @covers \drupol\Yaroc\RandomOrgAPI::call()
   */
  public function testUnknownMethod() {
    $result = $this->randomClient->call('izumi', ['n' => 5, 'min' => 0, 'max' => 100]);

    assert($result, equals(FALSE));
  }

  /**
   * @covers \drupol\Yaroc\RandomOrgAPI::setApiKey()
   * @covers \drupol\Yaroc\RandomOrgAPI::getApiKey()
   */
  public function testSetApiKey() {
    $apikey = 'IamBroggyAndIKnowIt';
    $this->randomClient->setApiKey($apikey);

    assert($this->randomClient->getApiKey(), equals($apikey));
  }

  /**
   * @covers \drupol\Yaroc\RandomOrgAPI::getHttpClient()
   * @covers \drupol\Yaroc\RandomOrgAPI::setHttpClient()
   */
  public function testHttpClient() {
    assert($this->randomClient->getHttpClient(), isInstanceOf('\drupol\Yaroc\Http\Client'));
  }

  /**
   * @covers \drupol\Yaroc\RandomOrgAPI::setMethodPluginManager()
   * @covers \drupol\Yaroc\RandomOrgAPI::getMethodPluginManager()
   */
  public function testMethodPluginManager() {
    assert($this->randomClient->getMethodPluginManager(), isInstanceOf('\drupol\Yaroc\Plugin\MethodPluginManager'));
  }

}
