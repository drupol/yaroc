## YAROC
[![Build Status](https://travis-ci.org/drupol/yaroc.svg?branch=master)](https://travis-ci.org/drupol/yaroc) [![Coverage Status](https://coveralls.io/repos/github/drupol/yaroc/badge.svg?branch=master)](https://coveralls.io/github/drupol/yaroc?branch=master)

Yet Another [Random.Org](https://random.org) Client

## API Keys
Get your own API key at https://api.random.org/api-keys
 
__The temporary Api Key (00000000-0000-0000-0000-000000000000) used in these examples will be disabled when the beta ends.__
 
## Installation

Installation with [Composer](https://getcomposer.org/):

```
  composer require drupol/yaroc
```

or by editing your ```composer.json``` file and add in the right section:

```json
{
  "require": {
    "drupol/yaroc": "dev-master"
  }
}
```

## Usage
First [request an API Key](https://api.random.org/api-keys) or use the temporary key.

You can call [any API methods described in the documentation](https://api.random.org/json-rpc/1/basic) from random.org.

Currently supports the methods below.

- generateIntegers
- generateDecimalFractions
- generateGaussians
- generateStrings
- generateUUIDs
- generateBlobs
- getUsage
- generateSignedIntegers
- generateSignedDecimalFractions
- generateSignedGaussians
- generateSignedStrings
- generateSignedUUIDs
- generateSignedBlobs
- verifySignature

Adding methods is quite easy and doesn't require adding methods to the class.
You can just add API methods by editing the ```RandomOrgAPI::getAPI()``` method and describe the arguments in there.

To call a method, use the ```RandomOrgAPI::call()``` method. Its arguments are:

- The ```method``` name (_see the list of supported method_)
- The ```parameters``` as an associative array (_see examples_)

The ```RandomOrgAPI::call()``` method will match parameters described in ```RandomOrgAPI::getAPI()``` method with the ```parameters``` argument.
If you pass in unsupported or unknown values to the ```parameters``` argument, they will be ignored automatically.

## Examples

```php

<?php

require 'vendor/autoload.php';

$httpclient = new Http\Adapter\Guzzle6\Client();
$randomClient = new drupol\Yaroc\RandomOrgAPI($httpclient);
$randomClient->setApiKey('00000000-0000-0000-0000-000000000000');

$result = $randomClient->call('generateIntegers', ['n' => 5, 'min' => 0, 'max' => 100]);
print_r($result);

$result = $randomClient->call('generateDecimalFractions', ['n' => 15, 'decimalPlaces' => 6]);
print_r($result);

$result = $randomClient->call('generateStrings', ['n' => 5, 'length' => 20]);
print_r($result);

$result = $randomClient->call('generateGaussians', ['n' => 5, 'mean' => 5, 'standardDeviation' => 3, 'significantDigits' => 3]);
print_r($result);

$result = $randomClient->call('generateUUIDs', ['n' => 6]);
print_r($result);

$result = $randomClient->call('generateBlobs', ['n' => 6, 'size' => 16]);
print_r($result);

$result = $randomClient->call('generateSignedIntegers', ['n' => 5, 'min' => 0, 'max' => 40]);
print_r($result);

$result = $randomClient->call('getUsage');
print_r($result);

```

## Tests coverage

Copy your API key in a file ```apikey``` at the root of the project. If you do not have it, the tests will use the temporary API key.

To run the tests, run this command:

```
composer phpunit tests
```

## TODO

- Response formatting
- Improve logging
- Documentation
- Tests coverage
