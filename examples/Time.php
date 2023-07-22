<?php

declare(strict_types=1);

namespace drupol\Yaroc\Examples;

use drupol\Yaroc\ApiMethods;

/**
 * @codeCoverageIgnore
 */
class Time extends BaseExample
{
    private array $time;

    public function find(): Time
    {
        $hours = $this
            ->getRandomOrgAPI()
            ->getData(
                ApiMethods::GenerateIntegers,
                ['n' => 1, 'min' => 0, 'max' => 23]
            );

        $minutesSeconds = $this
            ->getRandomOrgAPI()
            ->getData(
                ApiMethods::GenerateIntegers,
                ['n' => 2, 'min' => 0, 'max' => 59]
            );

        $this->time = [
            'h' => $hours[0],
            'm' => $minutesSeconds[0],
            's' => $minutesSeconds[1],
        ];

        return $this;
    }

    public function get(): array
    {
        return $this->time;
    }
}
