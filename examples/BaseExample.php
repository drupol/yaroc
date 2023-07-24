<?php

declare(strict_types=1);

namespace drupol\Yaroc\Examples;

use drupol\Yaroc\Client;
use drupol\Yaroc\ClientInterface;
use GuzzleHttp\Client as HttpClient;
use loophp\psr17\Psr17;
use Nyholm\Psr7\Factory\Psr17Factory;

/**
 * @codeCoverageIgnore
 */
abstract class BaseExample
{
    private ClientInterface $client;

    public function __construct()
    {
        $psr17 = new Psr17(
            new Psr17Factory(),
            new Psr17Factory(),
            new Psr17Factory(),
            new Psr17Factory(),
            new Psr17Factory(),
            new Psr17Factory(),
        );

        $this->client = new Client(
            new HttpClient(),
            $psr17,
            getenv('RANDOM_ORG_APIKEY')
        );
    }

    public function getRandomOrgAPI(): ClientInterface
    {
        return $this->client;
    }
}
