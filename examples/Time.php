<?php

declare(strict_types = 1);

namespace drupol\Yaroc\Examples;

use drupol\Yaroc\Plugin\Provider;

/**
 * Class Time.
 *
 * @codeCoverageIgnore
 */
class Time extends BaseExample
{
    /**
     * @var int[]
     */
    protected $time;

    /**
     * @return $this
     */
    public function find()
    {
        $provider = (new Provider())->withResource('generateIntegers');

        $hours = $this->getRandomOrgAPI()->getData(
            $provider->withParameters(
                ['n' => 1, 'min' => 0, 'max' => 23]
            )
        );
        $minutesSeconds = $this->getRandomOrgAPI()->getData(
            $provider->withParameters(
                ['n' => 2, 'min' => 0, 'max' => 59]
            )
        );

        $this->time = [
            'h' => $hours[0],
            'm' => $minutesSeconds[0],
            's' => $minutesSeconds[1],
        ];

        return $this;
    }

    /**
     * Get the time.
     *
     * @return int[]
     */
    public function get()
    {
        return $this->time;
    }
}
