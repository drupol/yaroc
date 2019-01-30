<?php

declare(strict_types = 1);

namespace drupol\Yaroc\Examples;

use drupol\Yaroc\Plugin\Provider;

/**
 * Class Dice.
 *
 * @codeCoverageIgnore
 */
class Dice extends BaseExample
{
    /**
     * @throws \Http\Client\Exception
     *
     * @return bool|mixed
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function roll()
    {
        $generateIntegers = Provider::withResource('generateIntegers')
            ->withParameters(['n' => 2, 'min' => 1, 'max' => 6]);

        return $this->getRandomOrgAPI()->getData($generateIntegers);
    }
}
