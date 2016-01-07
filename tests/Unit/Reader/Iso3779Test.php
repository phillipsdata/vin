<?php
namespace PhillipsData\Vin\Tests\Reader;

use PHPUnit_Framework_TestCase;
use PhillipsData\Vin\Reader\Iso3779;

/**
 * @coversDefaultClass \PhillipsData\Vin\Reader\Iso3779
 */
class Iso3779Test extends PHPUnit_Framework_TestCase
{

    /**
     * @covers ::number
     * @covers ::country
     * @covers ::expandCountries
     * @covers ::nextCountryToken
     * @dataProvider countryProvider
     *
     * @param string $number
     * @param string $expected
     */
    public function testCountry($number, $expected)
    {
        $reader = $this->getMockForAbstractClass('\PhillipsData\Vin\Reader\Iso3779');

        $reader->number($number);
        $this->assertEquals($expected, $reader->country());
    }

    /**
     * Data provider for testCountry()
     *
     * @return array
     */
    public function countryProvider()
    {
        return array(
            array('11111111111111111', 'US'),
            array('2A111111111111111', 'CA'),
            array('5A111111111111111', 'US'),
            array('90111111111111111', null),
            array('I1111111111111111', null),
            array('', null)
        );
    }
}
