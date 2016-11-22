<?php

namespace drupol\Yaroc\Tests;

use drupol\Yaroc\RandomOrgAPI;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
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

  protected $logfile = __DIR__ . '/yaroc.log';

  public function setUp() {
    parent::setUp();

    $this->randomClient = new RandomOrgAPI(NULL, new Logger('yaroc', [new StreamHandler(
      $this->logfile, Logger::DEBUG
    )]));

    $temporary_key = '00000000-0000-0000-0000-000000000000';
    if (file_exists(__DIR__ . '/../apikey') && $file_key = file_get_contents(__DIR__ . '/../apikey')) {
      $key = $file_key;
    } else {
      $key = $temporary_key;
    }

    $this->randomClient->setApiKey($key);
  }

  public function cleanLogs() {
    @unlink($this->logfile);
  }

  public function displayLogs() {
    echo @file_get_contents($this->logfile);
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
    $this->displayLogs();
    $this->cleanLogs();
  }

  /**
   * @covers ::generateIntegers()
   */
  public function testGenerateIntegers() {
    $result = $this->randomClient->call('generateIntegers', ['n' => 5, 'min' => 0, 'max' => 100]);

    assert(count($result['result']['random']['data']), equals(5));
    $this->displayLogs();
    $this->cleanLogs();
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
    $this->displayLogs();
    $this->cleanLogs();
  }
}
