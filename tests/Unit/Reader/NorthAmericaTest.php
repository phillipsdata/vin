<?php
namespace PhillipsData\Vin\Tests\Reader;

use PHPUnit_Framework_TestCase;
use PhillipsData\Vin\Reader\NorthAmerica;

/**
 * @coversDefaultClass \PhillipsData\Vin\Reader\NorthAmerica
 */
class NorthAmericaTest extends PHPUnit_Framework_TestCase
{
    private $reader;

    public function setUp()
    {
        $this->reader = new NorthAmerica();
    }

    /**
     * @covers ::valid
     * @covers ::validateCharacters
     * @covers ::validateCheckDigit
     * @uses \PhillipsData\Vin\Reader\Iso3779
     * @dataProvider validProvider
     *
     * @param string $number
     * @param bool $expected
     */
    public function testValid($number, $expected)
    {
        $this->reader->number($number);
        $this->assertEquals($expected, $this->reader->valid());
    }

    /**
     * Data provider for testValid()
     *
     * @return array
     */
    public function validProvider()
    {
        return array(
            // always valid all ones
            array('11111111111111111', true),
            // valid X check digit
            array('1M8GDM9AXKP042788', true),
            // typical valid vin
            array('5GZCZ43D13S812715', true),
            // invalid char in model year
            array('5GZCZ43D1US812715', false),
            // uses invalid I, O, Q
            array('IGZOZ43Q13S812715', false)
        );
    }

    /**
     * @covers ::year
     * @uses \PhillipsData\Vin\Reader\Iso3779
     * @dataProvider yearProvider
     *
     * @param string $number
     * @param bool $expected
     */
    public function testYear($number, $expected)
    {
        $this->reader->number($number);
        $this->assertEquals($expected, $this->reader->year());
    }

    /**
     * Data provider for testYear()
     *
     * @return array
     */
    public function yearProvider()
    {
        return array(
            // year = 1
            array('11111111111111111', array(2001, 2031)),
            // year = K
            array('1M8GDM9AXKP042788', array(1989, 2019)),
            // year = 3
            array('5GZCZ43D13S812715', array(2003, 2033)),
            // invalid year
            array('5GZCZ43D1US812715', array())
        );
    }
}
