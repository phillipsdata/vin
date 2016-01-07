# VIN

[![Build Status](https://travis-ci.org/phillipsdata/vin.svg?branch=master)](https://travis-ci.org/phillipsdata/vin) [![Coverage Status](https://coveralls.io/repos/phillipsdata/vin/badge.svg)](https://coveralls.io/r/phillipsdata/vin)

VIN (Vehicle Identification Number) validation and diagnostic library.

### Features

- Validates North American VIN numbers.
- Returns all possible years of manfacture for North American VIN numbers.
- Returns the country of manufacturer for VINs defined by ISO 3779.
- Supports custom readers for validating VINs outside of North America.

## Installation

Install via composer:

```sh
composer require phillipsdata/vin
```

## Basic Usage

```php
use PhillipsData\Vin\Number;

$vin = new Number('1M8GDM9AXKP042788');

$vin->valid(); // returns whether the VIN is valid
$vin->country(); // returns the ISO 3166 country code for the country of origin
$vin->number(); // returns the VIN number (e.g. 1M8GDM9AXKP042788)
$vin->year(); // returns an array of possible manufacturer years

```

## Advanced Usage

You can supply your own VIN reader. This allows you to implement a VIN reader
for vehicles manufactured in other countries (outside of North America).

```php
use PhillipsData\Vin\Number;

$vin = new Number('1M8GDM9AXKP042788', new PhillipsData\Vin\Reader\NorthAmerica());

$reader = $vin->reader(); // returns instance of PhillipsData\Vin\Reader\ReaderInterface

```

## Contributions

We're interested in contributions that add additional `PhillipsData\Vin\Reader\ReaderInterface`
implementations for unsupported regions.

We'd also love for this library to support extracting Manufacturer (e.g. Ford, Chevrolet, etc.)
based on the SAE's assignment of world manufacturer identifiers.
