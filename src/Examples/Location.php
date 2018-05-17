<?php

namespace drupol\Yaroc\Examples;

use drupol\Yaroc\Plugin\Provider;

/**
 * Class Location.
 */
class Location extends BaseExample
{
    /**
     * @var double[]
     */
    protected $coordinates;

    /**
     * @throws \Http\Client\Exception
     *
     * @return $this
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function find()
    {
        $provider = Provider::withResource('generateDecimalFractions')
            ->withParameters(['n' => 3, 'decimalPlaces' => 10]);

        $result = $this->getRandomOrgAPI()->getData($provider);

        $this->coordinates = [
            'x' => rad2deg($result[0] * 2 * pi() - pi()),
            'y' => rad2deg(pi()/2 - acos($result[1] * 2 - 1)),
            'z' => $result[2] * 1000,
        ];

        return $this;
    }

    /**
     * Get the coordinates.
     *
     * @return double[]
     */
    public function getCoordinates()
    {
        return $this->coordinates;
    }
}
