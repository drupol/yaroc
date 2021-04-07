<?php

declare(strict_types=1);

namespace drupol\Yaroc\Plugin\RychRandom\Generator;

use drupol\Yaroc\Plugin\Provider;
use drupol\Yaroc\RandomOrgAPI;
use drupol\Yaroc\RandomOrgAPIInterface;
use Rych\Random\Generator\GeneratorInterface;

/**
 * The Random.Org Generator.
 *
 * @codeCoverageIgnore
 */
final class RandomOrg implements GeneratorInterface
{
    /**
     * The Random.Org API.
     */
    protected RandomOrgAPIInterface $randomOrgAPI;

    public function __construct(RandomOrgAPIInterface $randomOrgAPI)
    {
        $this->randomOrgAPI = $randomOrgAPI;
    }

    /**
     * {@inheritdoc}
     */
    public function generate($size): string
    {
        $provider = (new Provider())->withResource('generateStrings')
            ->withParameters([
                'n' => 1,
                'length' => $size,
                'characters' => implode(
                    '',
                    array_merge(
                        range('A', 'Z'),
                        range('a', 'z'),
                        range(0, 9)
                    )
                ),
            ]);

        $result = $this->randomOrgAPI->getData($provider);

        return $result[0];
    }

    public static function getPriority(): int
    {
        return GeneratorInterface::PRIORITY_HIGH;
    }

    public static function isSupported(): bool
    {
        return class_exists(RandomOrgAPI::class);
    }
}
