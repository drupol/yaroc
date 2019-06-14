[![Latest Stable Version](https://img.shields.io/packagist/v/drupol/yaroc.svg?style=flat-square)](https://packagist.org/packages/drupol/yaroc)
 [![GitHub stars](https://img.shields.io/github/stars/drupol/yaroc.svg?style=flat-square)](https://packagist.org/packages/drupol/yaroc)
 [![Total Downloads](https://img.shields.io/packagist/dt/drupol/yaroc.svg?style=flat-square)](https://packagist.org/packages/drupol/yaroc)
 [![Build Status](https://img.shields.io/travis/drupol/yaroc/master.svg?style=flat-square)](https://travis-ci.org/drupol/yaroc)
 [![Scrutinizer code quality](https://img.shields.io/scrutinizer/quality/g/drupol/yaroc/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/drupol/yaroc/?branch=master)
 [![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/drupol/yaroc/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/drupol/yaroc/?branch=master)
 [![Mutation testing badge](https://badge.stryker-mutator.io/github.com/drupol/yaroc/master)](https://stryker-mutator.github.io)
 [![License](https://img.shields.io/packagist/l/drupol/yaroc.svg?style=flat-square)](https://packagist.org/packages/drupol/yaroc)

## YAROC

Yet Another [Random.Org](https://random.org) Client.

YAROC fully supports [V1](https://api.random.org/json-rpc/1/) and [V2](https://api.random.org/json-rpc/2) API.

Most of the classes of this library are stateless and immutable.

## Requirements

* PHP >= 7.0,
* A [PSR-7](http://www.php-fig.org/psr/psr-7/) http client ([Guzzle](https://github.com/guzzle/guzzle) library or any other equivalent),

## Installation

The first step to use `yaroc` is to install the dependencies with [Composer](https://getcomposer.org/):

```bash
$ composer install
```

Or if you need it in an existent project, then run the following command to install the dependencies:

```bash
$ composer require drupol/yaroc php-http/guzzle6-adapter
```

Why do we need `php-http/guzzle6-adapter` ?

We are decoupled form any HTTP messaging client with help by [HTTPlug](http://httplug.io/).
You may use any other HTTP client library that support [PSR-7](http://www.php-fig.org/psr/psr-7/).

## Usage
First [request an API Key](https://api.random.org/api-keys) or use the temporary key.

__The temporary API key used in the examples will be disabled when the beta ends.__

You can call [any API methods described in the documentation](https://api.random.org/json-rpc/1/basic) from [Random.org](https://random.org).

Currently support all the [Random.org](https://random.org) API methods in the basic and signed APIs.

## Examples

```php

<?php

require 'vendor/autoload.php';

$generateIntegers = \drupol\Yaroc\Plugin\Provider::withResource('generateIntegers')
    ->withParameters(['n' => 10, 'min' => 0, 'max' => 100]);

$result = (new drupol\Yaroc\RandomOrgAPI())
    ->withApiKey('00000000-0000-0000-0000-000000000000')
    ->getData($generateIntegers);

print_r($result);

$provider = \drupol\Yaroc\Plugin\Provider::withResource('generateStrings')
    ->withParameters([
        'n' => 10,
        'length' => 15,
        'characters' => implode(array_merge(range('A', 'Z'), range('a', 'z'), range(0, 9))),
    ]);

$result = (new drupol\Yaroc\RandomOrgAPI())
    ->getData($provider);

print_r($result);

// To use the upcoming version 2 of the random.org's API:

$result = (new drupol\Yaroc\RandomOrgAPI())
    ->withEndPoint('https://api.random.org/json-rpc/2/invoke')
    ->getData($provider);

print_r($result);


```

Providing the API key can be accomplished using a ```.env``` file. Copy the ```.env.dist``` file into ```.env``` and modify the latter accordingly.

## Third party libraries integration

### ircmaxell/RandomLib integration

YAROC provides a Source for [ircmaxell/RandomLib](https://github.com/ircmaxell/RandomLib).

```php
<?php

require 'vendor/autoload.php';

$randomLib = new RandomLib\Factory();
$generator = $randomLib->getGenerator(new SecurityLib\Strength(SecurityLib\Strength::HIGH))
  ->addSource(new \drupol\Yaroc\Plugin\RandomLib\Source\RandomOrg());
$randomString = $generator->generateString(10);

echo $randomString;

```
### rchouinard/rych-random integration

YAROC provides a Generator for [rchouinard/rych-random](https://github.com/rchouinard/rych-random).

```php
<?php

require 'vendor/autoload.php';

$rychRandom = new Rych\Random\Random(new \drupol\Yaroc\Plugin\RychRandom\Generator\RandomOrg());
$randomString = $rychRandom->getRandomString(8);

echo $randomString;

```

## Tests coverage

Make a copy of the file ```.env.dist``` into ```.env``` and set your API in it.
If you do not have it, the tests will use the temporary API key.

To run the tests, run this command:

```
composer grumphp
```

## History

I discovered the [Random.Org](https://random.org) the 22 November 2016, by chance and I found the idea amazing.

I had the idea to build a library that would be following the best development practice and up to date.

Feel free to contact me at: pol.dellaiera@protonmail.com

## TODO

- Documentation
- Tests coverage

