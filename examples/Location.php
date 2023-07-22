<?php

declare(strict_types=1);

namespace drupol\Yaroc\Examples;

use drupol\Yaroc\ApiMethods;

use const M_PI;

/**
 * @codeCoverageIgnore
 */
class Location extends BaseExample
{
    private array $coordinates;

    public function find(): Location
    {
        $result = $this
            ->getRandomOrgAPI()
            ->getData(
                ApiMethods::GenerateDecimalFractions,
                ['n' => 3, 'decimalPlaces' => 10]
            );

        $this->coordinates = [
            'x' => rad2deg($result[0] * 2 * M_PI - M_PI),
            'y' => rad2deg(M_PI / 2 - acos($result[1] * 2 - 1)),
            'z' => $result[2] * 1000,
        ];

        return $this;
    }

    public function getCoordinates(): array
    {
        return $this->coordinates;
    }
}
