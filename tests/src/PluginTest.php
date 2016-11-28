<?php

namespace drupol\Yaroc\Tests;

use drupol\Yaroc\Plugin\MethodPluginInterface;
use drupol\Yaroc\Plugin\MethodPluginManager;
use drupol\Yaroc\RandomOrgAPI;
use PHPUnit\Framework\TestCase;
use function \bovigo\assert\predicate\isOfSize;

/**
 * Class PluginTest.
 *
 * @package drupol\yaroc\Tests
 */
class PluginTest extends RandomOrgBase {

  /**
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
  public function testPluginsV1($method, MethodPluginInterface $plugin) {
    if (in_array($method, ['verifySignature', 'getUsage', 'getResult'])) {
      // We will test this plugin later.
      return;
    }

    $plugin->setApiVersion($this->randomOrgAPI->getApiVersion());

    $this->assertEquals($plugin->getMethod(), $plugin::METHOD);

    $params = $plugin->getTestsParameters() + ['apiKey' => $this->randomOrgAPI->getApiKey()];
    $plugin->setParameters($params);

    $parameters = $plugin->getParameters();
    $this->assertInternalType('array', $parameters);
    $this->assertInternalType('array', $plugin->getTestsParameters());

    // Find a way to test this.
    $result = $this->randomOrgAPI->call($method, $parameters['params'])
      ->getResult();
    $this->assertInternalType('array', $result);

    $this->assertEquals($parameters['params']['n'], count($result['random']['data']));
  }

  /**
   * @dataProvider getPluginsList
   */
  public function testPluginsV2($method, MethodPluginInterface $plugin) {
    if (in_array($method, ['verifySignature', 'getUsage', 'getResult'])) {
      // We will test this plugin later.
      return;
    }
    $this->randomOrgAPI->setApiVersion(2);
    $plugin->setApiVersion($this->randomOrgAPI->getApiVersion());

    $this->assertEquals($plugin->getMethod(), $plugin::METHOD);

    $params = $plugin->getTestsParameters() + ['apiKey' => $this->randomOrgAPI->getApiKey()];
    $plugin->setParameters($params);

    $parameters = $plugin->getParameters();
    $this->assertInternalType('array', $parameters);
    $this->assertInternalType('array', $plugin->getTestsParameters());

    // Find a way to test this.
    $result = $this->randomOrgAPI->call($method, $parameters['params'])
      ->getResult();
    $this->assertInternalType('array', $result);

    $this->assertEquals($parameters['params']['n'], count($result['random']['data']));
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
        $plugin->newInstance(),
      ];
    }

    return $plugins;
  }

}
