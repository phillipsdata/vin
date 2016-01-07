# PhillipsData\Vin

VIN (Vehicle Identification Number) validation and diagnostic library.

## Installation

Install via composer:

```php
composer require phillipsdata\vin
```

## Basic Usage

```php
use PhillipsData\Vin\Number;

$vin = new Number('1M8GDM9AXKP042788);

$vin->valid(); // returns whether the VIN is valid
$vin->country(); // returns the ISO 3166 country code for the country of origin
$vin->number(); // returns the VIN number (e.g. 1M8GDM9AXKP042788)
$vin->year(); // returns an array of possible manufacturer years

```

## Advanced Usage

You can supply your own VIN reader. This allows you to implement a VIN reader
for vehicles manufactured in other countries.

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


