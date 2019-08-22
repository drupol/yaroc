[![Latest Stable Version](https://img.shields.io/packagist/v/drupol/yaroc.svg?style=flat-square)](https://packagist.org/packages/drupol/yaroc)
 [![GitHub stars](https://img.shields.io/github/stars/drupol/yaroc.svg?style=flat-square)](https://packagist.org/packages/drupol/yaroc)
 [![Total Downloads](https://img.shields.io/packagist/dt/drupol/yaroc.svg?style=flat-square)](https://packagist.org/packages/drupol/yaroc)
 [![Build Status](https://img.shields.io/travis/drupol/yaroc/master.svg?style=flat-square)](https://travis-ci.org/drupol/yaroc)
 [![Scrutinizer code quality](https://img.shields.io/scrutinizer/quality/g/drupol/yaroc/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/drupol/yaroc/?branch=master)
 [![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/drupol/yaroc/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/drupol/yaroc/?branch=master)
 [![Mutation testing badge](https://badge.stryker-mutator.io/github.com/drupol/yaroc/master)](https://stryker-mutator.github.io)
 [![License](https://img.shields.io/packagist/l/drupol/yaroc.svg?style=flat-square)](https://packagist.org/packages/drupol/yaroc)
 [![Say Thanks!](https://img.shields.io/badge/Say-thanks-brightgreen.svg?style=flat-square)](https://saythanks.io/to/drupol)
 [![Donate!](https://img.shields.io/badge/Donate-Paypal-brightgreen.svg?style=flat-square)](https://paypal.me/drupol)
 
## YAROC

Yet Another [Random.Org](https://random.org) Client.

YAROC fully supports [V1](https://api.random.org/json-rpc/1/) and [V2](https://api.random.org/json-rpc/2) API.

Most of the classes of this library are stateless and immutable.

## Requirements

* PHP >= 7.1.3
* An HTTP Client (see [symfony/http-client](https://github.com/symfony/http-client))

## Installation

```bash
composer require drupol/yaroc
```

YAROC needs an HTTP client in order to work, do

```bash
composer require symfony/http-client
```

or provide one.

## Usage

First [request an API Key](https://api.random.org/api-keys) or use the temporary key.

__The temporary API key used in the examples will be disabled when the beta ends.__

You can call [any API methods described in the documentation](https://api.random.org/json-rpc/1/basic) from [Random.org](https://random.org).

Currently support all the [Random.org](https://random.org) API method calls in the [basic](https://api.random.org/json-rpc/2/basic) and [signed](https://api.random.org/json-rpc/2/signed) APIs.

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

Providing the API key can be accomplished using an environment variable `RANDOM_ORG_APIKEY` or by using the method proper
parameters in the `RandomOrgAPI` constructor, or by using `(new RandomOrgAPI())->withApiKey(string $apiKey)`. 

## Third party libraries integration

### ircmaxell/RandomLib integration

YAROC provides a Source for [ircmaxell/RandomLib](https://github.com/ircmaxell/RandomLib).

```php
<?php

require 'vendor/autoload.php';

use drupol\Yaroc\RandomOrgAPI;
use drupol\Yaroc\Plugin\RandomLib\Source\RandomOrg;

$randomOrgApi = new RandomOrgAPI();

$randomLib = new RandomLib\Factory();
$generator = $randomLib->getGenerator(new SecurityLib\Strength(SecurityLib\Strength::HIGH))
  ->addSource(new RandomOrg($randomOrgApi));
$randomString = $generator->generateString(10);

echo $randomString;

```
### rchouinard/rych-random integration

YAROC provides a Generator for [rchouinard/rych-random](https://github.com/rchouinard/rych-random).

```php
<?php

require 'vendor/autoload.php';

use drupol\Yaroc\RandomOrgAPI;
use drupol\Yaroc\Plugin\RychRandom\Generator\RandomOrg;

$randomOrgApi = new RandomOrgAPI();

$rychRandom = new Rych\Random\Random(new RandomOrg($randomOrgApi));
$randomString = $rychRandom->getRandomString(8);

echo $randomString;

```

## History

I discovered the [Random.Org](https://random.org) the 22 November 2016, by chance and I found the idea amazing.

I had the idea to build a library that would be following the best development practice and up to date.

Feel free to contact me at: pol.dellaiera@protonmail.com

## Code quality, tests and benchmarks

To run the tests, run this command:

```
RANDOM_ORG_APIKEY=xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx composer grumphp
```

Every time changes are introduced into the library, [Travis CI](https://travis-ci.org/drupol/phptree/builds) run the tests and the benchmarks.

The library has tests written with [PHPSpec](http://www.phpspec.net/).
Feel free to check them out in the `spec` directory. Run `composer phpspec` to trigger the tests.

Before each commit some inspections are executed with [GrumPHP](https://github.com/phpro/grumphp), run `./vendor/bin/grumphp run` to check manually.

[PHPInfection](https://github.com/infection/infection) is used to ensure that your code is properly tested, run `composer infection` to test your code.

## Contributing

Feel free to contribute to this library by sending Github pull requests. I'm quite reactive :-)
