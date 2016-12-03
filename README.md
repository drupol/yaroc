## YAROC
[![Build Status](https://travis-ci.org/drupol/yaroc.svg?branch=master)](https://travis-ci.org/drupol/yaroc) [![Codacy Badge](https://api.codacy.com/project/badge/Grade/7231dd2876b14e90a02cd1df9055309b)](https://www.codacy.com/app/drupol/yaroc) [![Codacy Badge](https://api.codacy.com/project/badge/Coverage/7231dd2876b14e90a02cd1df9055309b)](https://www.codacy.com/app/drupol/yaroc) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/drupol/yaroc/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/drupol/yaroc/?branch=master) [![Versioneye Status](https://www.versioneye.com/user/projects/58434f1d1f3a6d01f62cbee1/badge.svg)](https://www.versioneye.com/user/projects/58434f1d1f3a6d01f62cbee1)

Yet Another [Random.Org](https://random.org) Client.

YAROC fully supports [V1](https://api.random.org/json-rpc/1/) and [V2](https://api.random.org/json-rpc/2) API.

## Requirements

* PHP >= 5.6,
* A [PSR-7](http://www.php-fig.org/psr/psr-7/) http client ([Guzzle](https://github.com/guzzle/guzzle) library or any other equivalent),
* (optional) [PHPUnit](https://phpunit.de/) to run tests.

## Installation

The first step to use `yaroc` is to download [Composer](https://getcomposer.org/):

```bash
$ curl -s http://getcomposer.org/installer | php
```

Then run the following command to install the dependencies:

```bash
$ php composer.phar require drupol/yaroc php-http/guzzle6-adapter
```

Why do we need `php-http/guzzle6-adapter` ?

We are decoupled form any HTTP messaging client with help by [HTTPlug](http://httplug.io/).
You may use any other HTTP client library that support [PSR-7](http://www.php-fig.org/psr/psr-7/).

## Usage
First [request an API Key](https://api.random.org/api-keys) or use the temporary key.

__The temporary Api Key used in the examples will be disabled when the beta ends.__

You can call [any API methods described in the documentation](https://api.random.org/json-rpc/1/basic) from [Random.org](https://random.org).

Currently support all the [Random.org](https://random.org) API methods in the Basic and Signed APIs.

To call a method, use the ```RandomOrgAPI::call()``` method. Its arguments are:

- The ```method``` name (_see [the list of supported method](https://api.random.org/json-rpc/1/)_)
- The ```parameters``` as an associative array (_see examples_)

The ```RandomOrgAPI::call()``` method will check if the ```$method``` can be handled by a plugin.
If you pass in unsupported or unknown values to the ```parameters``` argument, they will be ignored automatically.

## Examples

```php

<?php

require 'vendor/autoload.php';

$randomOrgAPI = new drupol\Yaroc\RandomOrgAPI();
$randomOrgAPI->setApiKey('00000000-0000-0000-0000-000000000000');

$result = $randomOrgAPI->call('getUsage');
print_r($result->getFromResult('status'));

// Let's switch to API V2
$randomOrgAPI->setApiVersion(2);

$result = $randomOrgAPI->call('generateIntegers', ['n' => 5, 'min' => 0, 'max' => 100]);
print_r($result->getFromResult('bitsUsed'));
print_r($result->getData());

$result = $randomOrgAPI->call('generateDecimalFractions', ['n' => 15, 'decimalPlaces' => 6]);
print_r($result->getData());

$result = $randomOrgAPI->call('generateStrings', ['n' => 5, 'length' => 20]);
print_r($result->getData());

// Let's switch back to API V1
$randomOrgAPI->setApiVersion(1);

$result = $randomOrgAPI->call('generateGaussians', ['n' => 5, 'mean' => 5, 'standardDeviation' => 3, 'significantDigits' => 3]);
print_r($result->getData());

$result = $randomOrgAPI->call('generateUUIDs', ['n' => 6]);
print_r($result->getData());

$result = $randomOrgAPI->call('generateBlobs', ['n' => 6, 'size' => 16]);
print_r($result->getFromResult());

// Enable logging
$randomOrgAPI->setHttpClient(NULL, NULL, [
  new \Http\Client\Common\Plugin\LoggerPlugin(
    new \Monolog\Logger(
      'yaroc',
      [new \Monolog\Handler\StreamHandler(
        'php://stdout', \Monolog\Logger::DEBUG
      )]
    ),
    new Http\Message\Formatter\SimpleFormatter()
  )
]);

$result = $randomOrgAPI->call('generateSignedIntegers', ['n' => 5, 'min' => 0, 'max' => 40]);
print_r($result->get());

```

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

Copy your API key in a file ```apikey``` at the root of the project. If you do not have it, the tests will use the temporary API key.

To run the tests, run this command:

```
composer phpunit
```

## History

I discovered the [Random.Org](https://random.org) the 22 November 2016, by chance and I found the idea amazing.

I had the idea to build a library that would be following the best development practice and up to date.

Feel free to contact me at: pol.dellaiera@protonmail.com

## TODO

- Documentation
- Tests coverage

