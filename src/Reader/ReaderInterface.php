<?php
namespace PhillipsData\Vin\Reader;

/**
 * An interface for parsing VIN numbers as defined by ISO 3779 and ISO 3780
 */
interface ReaderInterface
{
    /**
     * Set the VIN
     *
     * @param string $number The Vehicle Identification Number
     */
    public function number($number);

    /**
     * Return whether the VIN is valid
     *
     * @return bool True if the number set is valid, false otherwise
     */
    public function valid();

    /**
     * Return the country of manufacture
     *
     * @return string|null ISO 3166 2-character country code of manufacture, null if not used
     */
    public function country();

    /**
     * Return possible years of manufacture
     *
     * @return array An array of possible years
     */
    public function year();
}
