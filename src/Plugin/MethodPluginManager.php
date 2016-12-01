<?php

namespace drupol\Yaroc\Plugin;

use drupol\Yaroc\Utilities\ClassFinder;

/**
 * Class MethodPluginManager.
 *
 * @package drupol\Yaroc\Plugin
 */
class MethodPluginManager {

  /**
   * Get the Method plugins.
   *
   * @return array
   */
  public function getPlugins() {
    $candidates = array_filter(
      ClassFinder::getClassesInNamespace('drupol\Yaroc\Plugin\Method'),
      function ($className) {
        return in_array('drupol\Yaroc\Plugin\MethodPluginInterface', class_implements($className));
      }
    );

    $classes = [];
    foreach ($candidates as $candidate) {
      $candidate = new \ReflectionClass($candidate);

      $classes[$candidate->getConstant('METHOD')] = $candidate;
    }

    return $classes;
  }

  /**
   * Get a specific Method plugin.
   *
   * @param string $methodName
   *   The method name to call.
   * @param array $params
   *   The params of the plugin.
   *
   * @return MethodPluginInterface|bool
   */
  public function getPlugin($methodName, array $params = array()) {
    $plugins = $this->getPlugins();

    if (isset($plugins[$methodName])) {
      /** @var \drupol\Yaroc\Plugin\MethodPluginInterface $plugin */
      return $plugins[$methodName]->newInstance()->setParameters($params);
    }

    return FALSE;
  }

}
