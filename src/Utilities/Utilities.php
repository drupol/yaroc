<?php

namespace drupol\Yaroc\Utilities;

/**
 * Class Utilities
 *
 * @package drupol\Yaroc\Utilities
 */
class Utilities {

  /**
   * Get the default allowed characters for generating random strings.
   *
   * @return string
   */
  static public function getDefaultRandomStringCharacters() {
    return implode(array_merge(range('A', 'Z'), range('a', 'z'), range(0, 9)));
  }

}
