<?php

namespace drupol\Yaroc\Tests;

use drupol\Yaroc\Plugin\MethodPluginInterface;
use drupol\Yaroc\Plugin\MethodPluginManager;
use drupol\Yaroc\RandomOrgAPI;
use PHPUnit\Framework\TestCase;
use function \bovigo\assert\predicate\equals;

/**
 * Class PluginTest.
 *
 * @package drupol\yaroc\Tests
 */
class PluginTest extends TestCase {

  /**
   * The client to test.
   *
   * @var RandomOrgAPI
   */
  protected $randomClient;

  public function setUp() {
    parent::setUp();

    $this->randomClient = new RandomOrgAPI();

    $temporary_key = '00000000-0000-0000-0000-000000000000';
    if (file_exists(__DIR__ . '/../apikey') && $file_key = file_get_contents(__DIR__ . '/../apikey')) {
      $key = $file_key;
    } else {
      $key = $temporary_key;
    }

    $this->randomClient->setApiKey($key);
  }

  /**
   * @covers \drupol\Yaroc\Plugin\Method\generateIntegers::getApiKey()
   * @covers \drupol\Yaroc\Plugin\Method\generateSignedIntegers::getApiKey()
   * @covers \drupol\Yaroc\Plugin\Method\generateBlobs::getApiKey()
   * @covers \drupol\Yaroc\Plugin\Method\generateSignedBlobs::getApiKey()
   * @covers \drupol\Yaroc\Plugin\Method\generateDecimalFractions::getApiKey()
   * @covers \drupol\Yaroc\Plugin\Method\generateSignedDecimalFractions::getApiKey()
   * @covers \drupol\Yaroc\Plugin\Method\generateStrings::getApiKey()
   * @covers \drupol\Yaroc\Plugin\Method\generateSignedStrings::getApiKey()
   * @covers \drupol\Yaroc\Plugin\Method\generateGaussians::getApiKey()
   * @covers \drupol\Yaroc\Plugin\Method\generateSignedGaussians::getApiKey()
   * @covers \drupol\Yaroc\Plugin\Method\generateUUIDs::getApiKey()
   * @covers \drupol\Yaroc\Plugin\Method\generateSignedUUIDs::getApiKey()
   *
   * @covers \drupol\Yaroc\Plugin\Method\generateIntegers::getTestsParameters()
   * @covers \drupol\Yaroc\Plugin\Method\generateSignedIntegers::getTestsParameters()
   * @covers \drupol\Yaroc\Plugin\Method\generateBlobs::getTestsParameters()
   * @covers \drupol\Yaroc\Plugin\Method\generateSignedBlobs::getTestsParameters()
   * @covers \drupol\Yaroc\Plugin\Method\generateDecimalFractions::getTestsParameters()
   * @covers \drupol\Yaroc\Plugin\Method\generateSignedDecimalFractions::getTestsParameters()
   * @covers \drupol\Yaroc\Plugin\Method\generateStrings::getTestsParameters()
   * @covers \drupol\Yaroc\Plugin\Method\generateSignedStrings::getTestsParameters()
   * @covers \drupol\Yaroc\Plugin\Method\generateGaussians::getTestsParameters()
   * @covers \drupol\Yaroc\Plugin\Method\generateSignedGaussians::getTestsParameters()
   * @covers \drupol\Yaroc\Plugin\Method\generateUUIDs::getTestsParameters()
   * @covers \drupol\Yaroc\Plugin\Method\generateSignedUUIDs::getTestsParameters()
   *
   * @covers \drupol\Yaroc\Plugin\Method\generateIntegers::setParameters()
   * @covers \drupol\Yaroc\Plugin\Method\generateSignedIntegers::setParameters()
   * @covers \drupol\Yaroc\Plugin\Method\generateBlobs::setParameters()
   * @covers \drupol\Yaroc\Plugin\Method\generateSignedBlobs::setParameters()
   * @covers \drupol\Yaroc\Plugin\Method\generateDecimalFractions::setParameters()
   * @covers \drupol\Yaroc\Plugin\Method\generateSignedDecimalFractions::setParameters()
   * @covers \drupol\Yaroc\Plugin\Method\generateStrings::setParameters()
   * @covers \drupol\Yaroc\Plugin\Method\generateSignedStrings::setParameters()
   * @covers \drupol\Yaroc\Plugin\Method\generateGaussians::setParameters()
   * @covers \drupol\Yaroc\Plugin\Method\generateSignedGaussians::setParameters()
   * @covers \drupol\Yaroc\Plugin\Method\generateUUIDs::setParameters()
   * @covers \drupol\Yaroc\Plugin\Method\generateSignedUUIDs::setParameters()
   *
   * @covers \drupol\Yaroc\Plugin\Method\generateIntegers::getMethod()
   * @covers \drupol\Yaroc\Plugin\Method\generateSignedIntegers::getMethod()
   * @covers \drupol\Yaroc\Plugin\Method\generateBlobs::getMethod()
   * @covers \drupol\Yaroc\Plugin\Method\generateSignedBlobs::getMethod()
   * @covers \drupol\Yaroc\Plugin\Method\generateDecimalFractions::getMethod()
   * @covers \drupol\Yaroc\Plugin\Method\generateSignedDecimalFractions::getMethod()
   * @covers \drupol\Yaroc\Plugin\Method\generateStrings::getMethod()
   * @covers \drupol\Yaroc\Plugin\Method\generateSignedStrings::getMethod()
   * @covers \drupol\Yaroc\Plugin\Method\generateGaussians::getMethod()
   * @covers \drupol\Yaroc\Plugin\Method\generateSignedGaussians::getMethod()
   * @covers \drupol\Yaroc\Plugin\Method\generateUUIDs::getMethod()
   * @covers \drupol\Yaroc\Plugin\Method\generateSignedUUIDs::getMethod()
   *
   * @covers \drupol\Yaroc\Plugin\Method\generateIntegers::getParameters()
   * @covers \drupol\Yaroc\Plugin\Method\generateSignedIntegers::getParameters()
   * @covers \drupol\Yaroc\Plugin\Method\generateBlobs::getParameters()
   * @covers \drupol\Yaroc\Plugin\Method\generateSignedBlobs::getParameters()
   * @covers \drupol\Yaroc\Plugin\Method\generateDecimalFractions::getParameters()
   * @covers \drupol\Yaroc\Plugin\Method\generateSignedDecimalFractions::getParameters()
   * @covers \drupol\Yaroc\Plugin\Method\generateStrings::getParameters()
   * @covers \drupol\Yaroc\Plugin\Method\generateSignedStrings::getParameters()
   * @covers \drupol\Yaroc\Plugin\Method\generateGaussians::getParameters()
   * @covers \drupol\Yaroc\Plugin\Method\generateSignedGaussians::getParameters()
   * @covers \drupol\Yaroc\Plugin\Method\generateUUIDs::getParameters()
   * @covers \drupol\Yaroc\Plugin\Method\generateSignedUUIDs::getParameters()
   *
   * @covers \drupol\Yaroc\Plugin\Method\generateIntegers::getDefaultParameters()
   * @covers \drupol\Yaroc\Plugin\Method\generateSignedIntegers::getDefaultParameters()
   * @covers \drupol\Yaroc\Plugin\Method\generateBlobs::getDefaultParameters()
   * @covers \drupol\Yaroc\Plugin\Method\generateSignedBlobs::getDefaultParameters()
   * @covers \drupol\Yaroc\Plugin\Method\generateDecimalFractions::getDefaultParameters()
   * @covers \drupol\Yaroc\Plugin\Method\generateSignedDecimalFractions::getDefaultParameters()
   * @covers \drupol\Yaroc\Plugin\Method\generateStrings::getDefaultParameters()
   * @covers \drupol\Yaroc\Plugin\Method\generateSignedStrings::getDefaultParameters()
   * @covers \drupol\Yaroc\Plugin\Method\generateGaussians::getDefaultParameters()
   * @covers \drupol\Yaroc\Plugin\Method\generateSignedGaussians::getDefaultParameters()
   * @covers \drupol\Yaroc\Plugin\Method\generateUUIDs::getDefaultParameters()
   * @covers \drupol\Yaroc\Plugin\Method\generateSignedUUIDs::getDefaultParameters()
   *
   * @dataProvider getPluginsList
   */
  public function testPlugins($method, MethodPluginInterface $plugin) {
    if ($method == 'verifySignature') {
      // We will test this plugin later.
      return;
    }

    $defaultParameters = $plugin->getDefaultParameters();
    $this->assertArrayHasKey('apiKey', $defaultParameters);

    $this->assertEquals($plugin->getMethod(), $plugin::METHOD);

    $plugin->setApiKey($this->randomClient->getApiKey());
    $this->assertEquals($plugin->getApiKey(), $this->randomClient->getApiKey());

    $this->assertInternalType('array', $plugin->getParameters());
    $this->assertInternalType('array', $plugin->getTestsParameters());

    $plugin->setParameters($plugin->getTestsParameters());

    // Find a way to test this.
    $result = $this->randomClient->getHttpClient()->request($plugin);
    $this->assertInternalType('array', $result);
  }

  /**
   * Data provider.
   *
   * @return array
   */
  public function getPluginsList() {
    $methodPluginManager = new MethodPluginManager();

    $plugins = [];
    foreach ($methodPluginManager->getPlugins() as $method => $plugin) {
      $plugins[] = [
        $method,
        $plugin
      ];
    }

    return $plugins;
  }

}
