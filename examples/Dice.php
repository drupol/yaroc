<?php

declare(strict_types=1);

namespace drupol\Yaroc\Examples;

use drupol\Yaroc\ApiMethods;

/**
 * @codeCoverageIgnore
 */
class Dice extends BaseExample
{
    public function roll(): array
    {
        return $this
            ->getRandomOrgAPI()
            ->getData(
                ApiMethods::GenerateIntegers,
                ['n' => 2, 'min' => 1, 'max' => 6]
            );
    }
}
