<?php

namespace drupol\Yaroc\Plugin\RandomLib\Source;

use drupol\Yaroc\Plugin\Provider;
use drupol\Yaroc\RandomOrgAPI;
use drupol\Yaroc\RandomOrgAPIInterface;
use SecurityLib\Strength;

/**
 * The Random.Org Source.
 *
 * @category   PHPCryptLib
 * @package    Random
 * @subpackage Source
 *
 * @author     Pol Dellaiera <pol.dellaiera@protonmail.com>
 * @codeCoverageIgnore
 */
class RandomOrg extends \RandomLib\AbstractSource
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
     * Return an instance of Strength indicating the strength of the source.
     *
     * @return \SecurityLib\Strength An instance of one of the strength classes
     */
    public static function getStrength()
    {
        return new Strength(Strength::HIGH);
    }

    /**
     * If the source is currently available.
     * Reasons might be because the library is not installed.
     *
     * @return bool
     */
    public static function isSupported()
    {
        return class_exists('RandomOrgAPI');
    }

    /**
     * Generate a random string of the specified size.
     *
     * @param int $size The size of the requested random string
     *
     * @throws \Http\Client\Exception
     *
     * @return string A string of the requested size
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
