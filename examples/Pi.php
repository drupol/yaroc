<?php

declare(strict_types = 1);

namespace drupol\Yaroc\Examples;

use drupol\Yaroc\Plugin\Provider;

/**
 * Class Pi.
 *
 * @codeCoverageIgnore
 */
class Pi extends BaseExample
{
    /**
     * @var float
     */
    protected $estimation;

    /**
     * @return float
     */
    public function get()
    {
        return $this->estimation;
    }

    /**
     * @param int $throws
     *
     * @throws \Http\Client\Exception
     *
     * @return $this
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function run($throws = 1000)
    {
        $provider = (new Provider())->withResource('generateDecimalFractions')
            ->withParameters(['n' => $throws * 2, 'decimalPlaces' => 6]);

        $numbers = $this->getRandomOrgAPI()->getData($provider);

        $inside = 0;
        for ($i = 0; $i < $throws; ++$i) {
            $x = $numbers[$i];
            $y = $numbers[$i + 1];

            if (1 >= \sqrt($x * $x + $y * $y)) {
                ++$inside;
            }
        }

        $this->estimation = 4 * $inside / $throws;

        return $this;
    }
}
