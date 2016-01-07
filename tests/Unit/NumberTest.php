<?php
namespace PhillipsData\Vin\Tests\Unit;

use PhillipsData\Vin\Number;
use PHPUnit_Framework_TestCase;

/**
 * @coversDefaultClass \PhillipsData\Vin\Number
 */
class NumberTest extends PHPUnit_Framework_TestCase
{
    private $vinOnes = '11111111111111111';

    /**
     * @covers ::__construct
     * @covers ::reader
     * @uses \PhillipsData\Vin\Reader\NorthAmerica
     * @uses \PhillipsData\Vin\Reader\Iso3779
     */
    public function testReader()
    {
        $vin = new Number($this->vinOnes);
        $this->assertInstanceOf(
            '\PhillipsData\Vin\Reader\ReaderInterface',
            $vin->reader()
        );
    }

    /**
     * @covers ::__construct
     * @covers ::number
     * @uses \PhillipsData\Vin\Reader\NorthAmerica
     * @uses \PhillipsData\Vin\Reader\Iso3779
     */
    public function testNumber()
    {
        $number = strtolower($this->vinOnes);

        $vin = new Number($number);
        $this->assertEquals($number, $vin->number());
    }

    /**
     * @covers ::__construct
     * @covers ::valid
     */
    public function testValid()
    {
        $reader = $this->getMockForAbstractClass('\PhillipsData\Vin\Reader\ReaderInterface');
        $reader->expects($this->once())
            ->method('valid')
            ->will($this->returnValue(false));

        $vin = new Number($this->vinOnes, $reader);

        $this->assertFalse($vin->valid());
    }

    /**
     * @covers ::__construct
     * @covers ::country
     */
    public function testCountry()
    {
        $country = 'US';
        $reader = $this->getMockForAbstractClass('\PhillipsData\Vin\Reader\ReaderInterface');
        $reader->expects($this->once())
            ->method('country')
            ->will($this->returnValue($country));

        $vin = new Number($this->vinOnes, $reader);

        $this->assertEquals($country, $vin->country());
    }

    /**
     * @covers ::__construct
     * @covers ::year
     */
    public function testYear()
    {
        $year = 2015;
        $reader = $this->getMockForAbstractClass('\PhillipsData\Vin\Reader\ReaderInterface');
        $reader->expects($this->once())
            ->method('year')
            ->will($this->returnValue($year));

        $vin = new Number($this->vinOnes, $reader);

        $this->assertEquals($year, $vin->year());
    }
}
