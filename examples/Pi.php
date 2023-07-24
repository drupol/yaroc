<?php

declare(strict_types=1);

namespace drupol\Yaroc\Examples;

use drupol\Yaroc\ApiMethods;

/**
 * @codeCoverageIgnore
 */
class Pi extends BaseExample
{
    private $estimation;

    public function get()
    {
        return $this->estimation;
    }

    public function run(int $throws = 1000): Pi
    {
        $numbers = $this
            ->getRandomOrgAPI()
            ->getData(
                ApiMethods::GenerateDecimalFractions,
                ['n' => $throws * 2, 'decimalPlaces' => 6]
            );

        $inside = 0;

        for ($i = 0; $i < $throws; ++$i) {
            $x = $numbers[$i];
            $y = $numbers[$i + 1];

            if (1 >= sqrt($x * $x + $y * $y)) {
                ++$inside;
            }
        }

        $this->estimation = 4 * $inside / $throws;

        return $this;
    }
}
