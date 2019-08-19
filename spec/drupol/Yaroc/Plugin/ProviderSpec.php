<?php

declare(strict_types=1);

namespace spec\drupol\Yaroc\Plugin;

use drupol\Yaroc\Plugin\Provider;
use drupol\Yaroc\RandomOrgAPI;
use PhpSpec\ObjectBehavior;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Contracts\HttpClient\ResponseInterface;

/**
 * Class ProviderSpec.
 */
class ProviderSpec extends ObjectBehavior
{
    public function it_can_do_a_request(): void
    {
        $randomOrgApi = new RandomOrgAPI();

        $this
            ->withEndPoint($randomOrgApi->getEndPoint())
            ->withResource('getUsage')
            ->request()
            ->shouldImplement(ResponseInterface::class);
    }

    public function it_can_get_its_endpoint(): void
    {
        $this
            ->getParameters()
            ->shouldReturn([]);

        $this
            ->withParameters(['foo' => 'bar'])
            ->getParameters()
            ->shouldReturn(['foo' => 'bar']);
    }

    public function it_can_get_the_endpoint(): void
    {
        $this
            ->getEndPoint()
            ->shouldReturn(null);

        $this
            ->withEndPoint('bar')
            ->getEndpoint()
            ->shouldReturn('bar');
    }

    public function it_can_get_the_resource(): void
    {
        $this
            ->getResource()
            ->shouldReturn(null);

        $this
            ->withResource('foo')
            ->getResource()
            ->shouldReturn('foo');
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(Provider::class);
    }

    public function let(): void
    {
        $mock = static function (string $method, string $url, array $options) {
            return new MockResponse($url, $options);
        };

        $client = new MockHttpClient($mock, null, ['headers' => ['User-Agent' => 'YAROC (http://github.com/drupol/yaroc)']]);

        $this->beConstructedWith($client);
    }
}
