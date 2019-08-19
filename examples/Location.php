<?php

declare(strict_types=1);

namespace drupol\Yaroc\Examples;

use drupol\Yaroc\Plugin\Provider;

/**
 * Class Location.
 *
 * @codeCoverageIgnore
 */
class Location extends BaseExample
{
    /**
     * @var float[]
     */
    protected $coordinates;

    /**
     * @return $this
     */
    public function find()
    {
        $provider = (new Provider())->withResource('generateDecimalFractions')
            ->withParameters(['n' => 3, 'decimalPlaces' => 10]);

        $result = $this->getRandomOrgAPI()->getData($provider);

        $this->coordinates = [
            'x' => \rad2deg($result[0] * 2 * \M_PI - \M_PI),
            'y' => \rad2deg(\M_PI / 2 - \acos($result[1] * 2 - 1)),
            'z' => $result[2] * 1000,
        ];

        return $this;
    }

    /**
     * Get the coordinates.
     *
     * @return float[]
     */
    public function getCoordinates()
    {
        return $this->coordinates;
    }
}
