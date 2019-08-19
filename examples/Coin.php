<?php

declare(strict_types=1);

namespace drupol\Yaroc\Examples;

use drupol\Yaroc\Plugin\Provider;

/**
 * Class Coin.
 *
 * @codeCoverageIgnore
 */
class Coin extends BaseExample
{
    /**
     * @var string
     */
    protected $face;

    /**
     * @return $this
     */
    public function flip()
    {
        $parameters = ['n' => 1, 'min' => 0, 'max' => 1];

        $generateIntegers = (new Provider())->withResource('generateIntegers')
            ->withParameters($parameters);

        $result = $this->getRandomOrgAPI()->getData($generateIntegers);

        $this->face = (1 === $result[0]) ? 'tails' : 'heads';

        return $this;
    }

    /**
     * Get the coin face.
     *
     * @return string
     */
    public function getFace()
    {
        return $this->face;
    }
}
