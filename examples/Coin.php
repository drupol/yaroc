<?php

declare(strict_types=1);

namespace drupol\Yaroc\Examples;

use drupol\Yaroc\ApiMethods;

/**
 * @codeCoverageIgnore
 */
class Coin extends BaseExample
{
    protected string $face;

    public function flip(): Coin
    {
        $parameters = ['n' => 1, 'min' => 0, 'max' => 1];

        $result = $this->getRandomOrgAPI()->getData(ApiMethods::GenerateIntegers, $parameters);

        $this->face = (1 === $result[0]) ? 'tails' : 'heads';

        return $this;
    }

    public function getFace(): string
    {
        return $this->face;
    }
}
