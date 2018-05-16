<?php

namespace spec\drupol\Yaroc;

use drupol\Yaroc\RandomOrgAPI;
use Http\Client\HttpClient;
use PhpSpec\ObjectBehavior;

class RandomOrgAPISpec extends ObjectBehavior
{
    public function let()
    {
        $filename = __DIR__ . '/../../../.env';

        if (file_exists($filename)) {
            rename($filename, $filename . '.bak');
        }
    }

    public function letGo()
    {
        $filename = __DIR__ . '/../../../.env.bak';

        if (file_exists($filename)) {
            rename($filename, substr($filename, 0, -4));
        }
    }

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
            ->shouldBe('00000000-0000-0000-0000-000000000000');

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
