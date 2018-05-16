<?php

namespace drupol\Yaroc\Examples;

use drupol\Yaroc\Plugin\Provider;

/**
 * Class Pi.
 */
class Pi extends BaseExample
{
    /**
     * @var float
     */
    protected $estimation;

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
        $provider = Provider::withResource('generateDecimalFractions')
            ->withParameters(['n' => $throws * 2, 'decimalPlaces' => 6]);

        $numbers = $this->getRandomOrgAPI()->getData($provider);

        $inside = 0;
        for ($i = 0; $i < $throws; $i++) {
            $x = $numbers[$i];
            $y = $numbers[$i+1];

            if (sqrt($x*$x + $y*$y) <= 1) {
                $inside++;
            }
        }

        $this->estimation = 4 * $inside/$throws;

        return $this;
    }

    /**
     * @return float
     */
    public function get()
    {
        return $this->estimation;
    }
}
