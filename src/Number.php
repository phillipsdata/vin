<?php
namespace PhillipsData\Vin;

use PhillipsData\Vin\Reader\ReaderInterface;
use PhillipsData\Vin\Reader\NorthAmerica;

/**
 * Vehicle Identification Number
 */
class Number
{
    /**
     * @var string The VIN
     */
    private $number;
    /**
     * @var \PhillipsData\Vin\Reader\ReaderInterface The VIN Reader
     */
    private $reader;

    /**
     * Initalize a VIN
     *
     * @param string $number The VIN
     * @param PhillipsData\Vin\Reader\ReaderInterface $reader The VIN reader
     */
    public function __construct($number, ReaderInterface $reader = null)
    {
        $this->number = $number;
        $this->reader = $reader;

        if (null === $reader) {
            $this->reader = new NorthAmerica();
        }

        $this->reader->number($number);
    }

    /**
     * Returns the VIN Reader in use
     *
     * @return \PhillipsData\Vin\Reader\ReaderInterface
     */
    public function reader()
    {
        return $this->reader;
    }

    /**
     * The VIN given
     *
     * @return string The VIN
     */
    public function number()
    {
        return $this->number;
    }

    /**
     * Check whether the VIN is valid
     *
     * @return bool True if valid, false otherwise
     */
    public function valid()
    {
        return $this->reader->valid();
    }

    /**
     * The country of manufacture in ISO 3166 2-character format
     *
     * @return string|null The 2-cahracter ISO 3166, null if unknown
     */
    public function country()
    {
        return $this->reader->country();
    }

    /**
     * Possible years the VIN may pertain
     *
     * @return array An array of possible years
     */
    public function year()
    {
        return $this->reader->year();
    }
}
