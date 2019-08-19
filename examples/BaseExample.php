<?php

declare(strict_types=1);

namespace drupol\Yaroc\Examples;

use drupol\Yaroc\RandomOrgAPI;

/**
 * @codeCoverageIgnore
 */
abstract class BaseExample
{
    /**
     * The Random.org API bridge.
     *
     * @var \drupol\Yaroc\RandomOrgAPI
     */
    private $randomOrgAPI;

    /**
     * BaseExample constructor.
     */
    public function __construct()
    {
        $this->randomOrgAPI = new RandomOrgAPI();
    }

    /**
     * Get the Random.org API bridge.
     *
     * @return \drupol\Yaroc\RandomOrgAPI
     */
    public function getRandomOrgAPI()
    {
        return $this->randomOrgAPI;
    }
}
