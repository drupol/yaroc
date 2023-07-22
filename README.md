[![Latest Stable Version][latest stable version]][packagist]
[![GitHub stars][github stars]][packagist]
[![Total Downloads][total downloads]][packagist]
[![GitHub Workflow Status][github workflow status]][github actions]
[![Type Coverage][type coverage]][sheperd type coverage]
[![License][license]][packagist] [![Donate!][donate github]][github sponsor]

## YAROC

Yet Another [Random.Org](https://random.org) Client.

YAROC fully supports [V4](https://api.random.org/json-rpc/4/).

## Requirements

- PHP >= 8.1

## Installation

```bash
composer require drupol/yaroc
```

## Usage

First [request an API Key](https://api.random.org/api-keys).

You can call
[any API methods described in the documentation](https://api.random.org/json-rpc/4/basic)
from [Random.org](https://random.org).

Currently support all the [Random.org](https://random.org) API method calls in
the [basic](https://api.random.org/json-rpc/4/basic) and
[signed](https://api.random.org/json-rpc/4/signed) APIs.

## Examples

```php
<?php

require 'vendor/autoload.php';

use drupol\Yaroc\Plugin\Provider;
use drupol\Yaroc\RandomOrgAPI;

$generateIntegers = (new Provider())->withResource('generateIntegers')
    ->withParameters(['n' => 10, 'min' => 0, 'max' => 100]);

$result = (new RandomOrgAPI())
    ->withApiKey('00000000-0000-0000-0000-000000000000')
    ->getData($generateIntegers);

print_r($result);

$provider = (new Provider())->withResource('generateStrings')
    ->withParameters([
        'n' => 10,
        'length' => 15,
        'characters' => implode(array_merge(range('A', 'Z'), range('a', 'z'), range(0, 9))),
    ]);

$result = (new RandomOrgAPI(null, ['apiKey' => '00000000-0000-0000-0000-000000000000']))->getData($provider);

print_r($result);
```

Providing the API key can be accomplished using an environment variable
`RANDOM_ORG_APIKEY` or by using the method proper parameters in the
`RandomOrgAPI` constructor, or by using
`(new RandomOrgAPI())->withApiKey(string $apiKey)`.

## History

I discovered the [Random.Org](https://random.org) the 22 November 2016, by
chance and I found the idea amazing.

I had the idea to build a library that would be following the best development
practices.

## Code quality, tests and benchmarks

To run the tests, run this command:

```shell
RANDOM_ORG_APIKEY=xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx composer grumphp
```

Before each commit some inspections are executed with
[GrumPHP](https://github.com/phpro/grumphp), run `./vendor/bin/grumphp run` to
check manually.

[PHPInfection](https://github.com/infection/infection) is used to ensure that
your code is properly tested, run `composer infection` to test your code.

## Contributing

Feel free to contribute by sending Github pull requests.

If you can't contribute to the code, you can also sponsor me on
[Github][github sponsor].

## Changelog

See [CHANGELOG.md][changelog-md] for a changelog based on [git
commits][git-commits].

[packagist]: https://packagist.org/packages/drupol/yaroc
[latest stable version]:
  https://img.shields.io/packagist/v/drupol/yaroc.svg?style=flat-square
[github stars]:
  https://img.shields.io/github/stars/drupol/yaroc.svg?style=flat-square
[total downloads]:
  https://img.shields.io/packagist/dt/drupol/yaroc.svg?style=flat-square
[github workflow status]:
  https://img.shields.io/github/actions/workflow/status/drupol/yaroc/tests.yml?branch=master&style=flat-square
[type coverage]:
  https://img.shields.io/badge/dynamic/json?style=flat-square&color=color&label=Type%20coverage&query=message&url=https%3A%2F%2Fshepherd.dev%2Fgithub%2Fdrupol%2Fyaroc%2Fcoverage
[sheperd type coverage]: https://shepherd.dev/github/drupol/yaroc
[license]: https://img.shields.io/packagist/l/drupol/yaroc.svg?style=flat-square
[donate github]:
  https://img.shields.io/badge/Sponsor-Github-brightgreen.svg?style=flat-square
[github actions]: https://github.com/drupol/yaroc/actions
[github sponsor]: https://github.com/sponsors/drupol
[changelog-md]: https://github.com/drupol/yaroc/blob/master/CHANGELOG.md
[git-commits]: https://github.com/drupol/yaroc/commits/master
[changelog-releases]: https://github.com/drupol/yaroc/releases
