<?php

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
class RandomOrg implements GeneratorInterface
{
    /**
     * The Random.Org API.
     *
     * @var RandomOrgAPI
     */
    protected $randomOrgAPI;

    /**
     * RandomOrg constructor.
     *
     * @param \drupol\Yaroc\RandomOrgAPIInterface $randomOrgAPI
     */
    public function __construct(RandomOrgAPIInterface $randomOrgAPI)
    {
        $this->randomOrgAPI = $randomOrgAPI;
    }

    /**
     * {@inheritdoc}
     */
    public static function getPriority()
    {
        return GeneratorInterface::PRIORITY_HIGH;
    }

    /**
     * {@inheritdoc}
     */
    public static function isSupported()
    {
        return class_exists('RandomOrgAPI');
    }

    /**
     * {@inheritdoc}
     */
    public function generate($size)
    {
        $provider = Provider::withResource('generateStrings')
            ->withParameters([
                'n' => 1,
                'length' => $size,
                'characters' => implode(array_merge(range('A', 'Z'), range('a', 'z'), range(0, 9))),
            ]);
        $result = $this->randomOrgAPI->getData($provider);

        return $result[0];
    }
}
