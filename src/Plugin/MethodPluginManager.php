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
      $candidate = $candidate->newInstance();

      $classes[$candidate::METHOD] = $candidate;
    }

    return $classes;
  }

  /**
   * Get a specific Method plugin.
   *
   * @param string $methodName
   *
   * @return MethodPluginInterface|bool
   */
  public function getPlugin($methodName) {
    $plugins = $this->getPlugins();

    if (isset($plugins[$methodName])) {
      return $plugins[$methodName];
    }

    return FALSE;
  }

}
