<?php

namespace spec\drupol\Yaroc;

use drupol\Yaroc\RandomOrgAPI;
use Http\Client\HttpClient;
use PhpSpec\ObjectBehavior;

class RandomOrgAPISpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(RandomOrgAPI::class);
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

    public function it_can_set_an_apikey()
    {
        $this->getApiKey()
            ->shouldNotBe('');

        $this
            ->withApiKey('http://hello.world/')
            ->getApiKey()
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

    public function it_can_get_the_configuration()
    {
        $this
            ->withApiKey('123')
            ->getConfiguration()
            ->shouldBe(['apiKey' => '123']);
    }
}
