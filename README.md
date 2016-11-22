## YAROC
[![Build Status](https://travis-ci.org/drupol/yaroc.svg?branch=master)](https://travis-ci.org/drupol/yaroc)

Yet Another [Random.Org](https://random.org) Client
 
## Installation

Installation must be done through [Composer](https://getcomposer.org/):

```
  composer require drupol/yaroc
```

or by editing your composer.json file and add in the right section:

```json
{
  "require": {
    "drupol/yaroc": "dev-master"
  }
}
```

## Usage

First [request an API Key](https://api.random.org/api-keys/beta).

You can call [any API methods described in the documentation](https://api.random.org/json-rpc/1/basic) from random.org.


```php

<?php

require 'vendor/autoload.php';

$httpclient = new Http\Adapter\Guzzle6\Client();
$randomClient = new drupol\Yaroc\RandomOrgAPI($httpclient);
$randomClient->setApiKey(YOUR_API_KEY_HERE);

$numbers = $randomClient->call('generateIntegers', ['n' => 5, 'min' => 0, 'max' => 100]);
print_r($numbers);

$numbers = $randomClient->call('generateDecimalFractions', ['n' => 15, 'decimalPlaces' => 6]);
print_r($numbers);

$numbers = $randomClient->call('generateStrings', ['n' => 5, 'length' => 20]);
print_r($numbers);

$numbers = $randomClient->call('generateGaussians', ['n' => 5, 'mean' => 5, 'standardDeviation' => 3, 'significantDigits' => 3]);
print_r($numbers);

$numbers = $randomClient->call('generateUUIDs', ['n' => 6]);
print_r($numbers);

$numbers = $randomClient->call('generateBlobs', ['n' => 6, 'size' => 16]);
print_r($numbers);

$numbers = $randomClient->call('generateSignedIntegers', ['n' => 5, 'min' => 0, 'max' => 40]);
print_r($numbers);

$numbers = $randomClient->call('getUsage');
print_r($numbers);

```

## Tests coverage

Copy your API key in a file ```apikey``` at the root of the project.

To run the tests, run this command:

```
composer phpunit tests
```
