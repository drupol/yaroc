<?php

declare(strict_types = 1);

namespace spec\drupol\Yaroc;

use drupol\Yaroc\Plugin\Provider;
use drupol\Yaroc\RandomOrgAPI;
use Http\Client\HttpClient;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\ResponseInterface;

class RandomOrgAPISpec extends ObjectBehavior
{
    public $provider;

    public function it_can_call_a_provider()
    {
        $this->call($this->provider)
            ->shouldBeAnInstanceOf(ResponseInterface::class);
    }

    public function it_can_get()
    {
        $get = $this->get($this->provider);
        $get->shouldBeArray();
        $get->shouldHaveKey('jsonrpc');
        $get->shouldHaveKey('id');
        $get->shouldHaveKey('result');
    }

    public function it_can_get_data()
    {
        $get = $this->getData($this->provider);
        $get->shouldBeArray();
        $get->shouldHaveCount(10);
    }

    public function it_can_get_the_configuration()
    {
        $this
            ->withApiKey('123')
            ->getConfiguration()
            ->shouldBe(['apiKey' => '123']);
    }

    public function it_can_query_new_api_version()
    {
        $data = $this
            ->withEndPoint('https://api.random.org/json-rpc/2/invoke')
            ->getData($this->provider);
        $data->shouldBeArray();
        $data->shouldHaveCount(10);
    }

    public function it_can_return_the_right_errorcode()
    {
        $provider = Provider::withResource('generateIntegers')
            ->withParameters(['n' => 10, 'min' => 0, 'max' => 100, 'unexistent' => 'test']);
        $this->shouldThrow(\InvalidArgumentException::class)->during('call', [$provider]);

        $provider = Provider::withResource('unexistentResource')
            ->withParameters([]);
        $this->shouldThrow(\BadFunctionCallException::class)->during('call', [$provider]);

        $provider = Provider::withResource('generateIntegers')
            ->withParameters(['n' => 10, 'min' => 0, 'max' => 100]);
        $this->withApiKey('plop')->shouldThrow(\RuntimeException::class)->during('call', [$provider]);
    }

    public function it_can_set_an_apikey()
    {
        $this->getApiKey()
            ->shouldNotBe('');

        $this
            ->withApiKey('http://hello.world/')
            ->getApiKey()
            ->shouldBe('http://hello.world/');
    }

    public function it_can_set_an_endpoint()
    {
        $this->getEndPoint()
            ->shouldBe('https://api.random.org/json-rpc/1/invoke');

        $this
            ->withEndPoint('http://hello.world/')
            ->getEndPoint()
            ->shouldBe('http://hello.world/');
    }

    public function it_can_set_an_httpclient(HttpClient $httpClient)
    {
        $this->getHttpClient()
            ->shouldNotBeNull();

        $this
            ->withHttpClient($httpClient)
            ->getHttpClient()
            ->shouldBe($httpClient);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(RandomOrgAPI::class);
    }

    public function let()
    {
        $this->provider = Provider::withResource('generateIntegers')
            ->withParameters(['n' => 10, 'min' => 0, 'max' => 100]);
    }
}
