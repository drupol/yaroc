<?php

namespace drupol\Yaroc\Tests;

use drupol\Yaroc\Plugin\MethodPluginManager;
use Psr\Http\Message\ResponseInterface;

/**
 * Class RandomOrgAPITest.
 *
 * @package drupol\yaroc\Tests
 */
class RandomOrgAPITest extends RandomOrgBase {

  /**
   * @var MethodPluginManager
   */
  protected $methodPluginManager;

  /**
   * @covers \drupol\Yaroc\RandomOrgAPI::setEndpoint()
   * @covers \drupol\Yaroc\RandomOrgAPI::getEndpoint()
   */
  public function testEndpoint() {
    $url = 'http://my/url/%s';
    $this->randomOrgAPI->setApiVersion(1);
    $this->randomOrgAPI->setEndpoint($url);

    $this->assertEquals('http://my/url/1', $this->randomOrgAPI->getEndpoint());
    $this->assertInstanceOf('\Psr\Http\Message\UriInterface', $this->randomOrgAPI->getHttpClient()->getEndpoint());
  }

  /**
   * @covers \drupol\Yaroc\RandomOrgAPI::setApiVersion()
   * @covers \drupol\Yaroc\RandomOrgAPI::getApiVersion()
   */
  public function testApiVersion() {
    $this->randomOrgAPI->setApiVersion(3);
    $this->assertEquals(3, $this->randomOrgAPI->getApiVersion());
  }

  /**
   * @covers \drupol\Yaroc\RandomOrgAPI::call()
   */
  public function testUnknownMethod() {
    $result = $this->randomOrgAPI->call('izumi', ['n' => 5, 'min' => 0, 'max' => 100])->getFromResult();

    $this->assertFalse($result);
  }

  /**
   * @covers \drupol\Yaroc\RandomOrgAPI::setApiKey()
   * @covers \drupol\Yaroc\RandomOrgAPI::getApiKey()
   */
  public function testSetApiKey() {
    $apikey = 'IamBroggyAndIKnowIt';
    $this->randomOrgAPI->setApiKey($apikey);

    $this->assertEquals($apikey, $this->randomOrgAPI->getApiKey());
  }

  /**
   * @covers \drupol\Yaroc\RandomOrgAPI::getHttpClient()
   * @covers \drupol\Yaroc\RandomOrgAPI::setHttpClient()
   */
  public function testHttpClient() {
    $this->assertInstanceOf('\drupol\Yaroc\Http\Client', $this->randomOrgAPI->getHttpClient());
  }

  /**
   * @covers \drupol\Yaroc\RandomOrgAPI::setMethodPluginManager()
   * @covers \drupol\Yaroc\RandomOrgAPI::getMethodPluginManager()
   */
  public function testMethodPluginManager() {
    $this->assertInstanceOf('\drupol\Yaroc\Plugin\MethodPluginManager', $this->randomOrgAPI->getMethodPluginManager());
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
    $this->randomOrgAPI->call($method, $params);
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
    $this->assertFalse($this->randomOrgAPI->call($method, $params)->getFromResult());
  }

  /**
   * @covers \drupol\Yaroc\RandomOrgAPI::__construct()
   */
  public function testConstructor() {
    $this->assertInstanceOf('\drupol\Yaroc\Http\Client', $this->randomOrgAPI->getHttpClient());
    $this->assertInstanceOf('\drupol\Yaroc\Plugin\MethodPluginManager', $this->randomOrgAPI->getMethodPluginManager());
    $this->assertEquals($this->randomOrgAPI->getEndpoint(), $this->randomOrgAPI->getHttpClient()->getEndpoint());
    $this->assertFalse($this->randomOrgAPI->getResponse());
    $this->assertFalse($this->randomOrgAPI->getFromResult());
  }

  /**
   * @covers \drupol\Yaroc\RandomOrgAPI::getResponse()
   * @covers \drupol\Yaroc\RandomOrgAPI::setResponse()
   * @covers \drupol\Yaroc\RandomOrgAPI::setMethodPlugin()
   * @covers \drupol\Yaroc\RandomOrgAPI::getFromResult()
   * @covers \drupol\Yaroc\Plugin\MethodPluginBase::get()
   * @covers \drupol\Yaroc\Plugin\MethodPluginBase::getFromResult()
   */
  public function testResponse() {
    $method = 'generateIntegers';
    $params = [
      'n' => 5,
      'min' => 0,
      'max' => 5,
    ];
    $this->assertInstanceOf('\drupol\Yaroc\RandomOrgAPI', $this->randomOrgAPI->call($method, $params));
    $this->assertInstanceOf('\Psr\Http\Message\ResponseInterface', $this->randomOrgAPI->getResponse());
    $this->assertInternalType('array', $this->randomOrgAPI->getFromResult());
  }

  /**
   * @covers \drupol\Yaroc\RandomOrgAPI::call()
   * @covers \drupol\Yaroc\RandomOrgAPI::request()
   * @covers \drupol\Yaroc\RandomOrgAPI::getResponse()
   * @covers \drupol\Yaroc\RandomOrgAPI::setEndpoint()
   * @covers \drupol\Yaroc\RandomOrgAPI::getEndpoint()
   * @covers \drupol\Yaroc\RandomOrgAPI::getFromResult()
   */
  public function testRequestCall() {
    $this->randomOrgAPI->setEndpoint('http://yaroc/%s');
    $method = 'generateIntegers';
    $params = [
      'n' => 5,
      'min' => 0,
      'max' => 5,
    ];
    $this->assertNull($this->randomOrgAPI->call($method, $params)->getResponse());
    $this->assertFalse($this->randomOrgAPI->getFromResult());
  }

}
