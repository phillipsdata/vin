<?php
namespace PhillipsData\Vin\Reader;

/**
 * North American VIN Reader
 */
class NorthAmerica extends Iso3779
{
    /**
     * @var array Weights used in calculating the check digit
     */
    private static $weights = array(8, 7, 6, 5, 4, 3, 2, 10, 0, 9, 8, 7, 6, 5, 4, 3, 2);
    /**
     * @var array Mapping of VIN codes to check digit value (I, O, and Q are intentionally excluded)
     */
    private static $map = array(
        'A' => 1, 'B' => 2, 'C' => 3, 'D' => 4, 'E' => 5, 'F' => 6, 'G' => 7, 'H' => 8,
        'J' => 1, 'K' => 2, 'L' => 3, 'M' => 4, 'N' => 5,           'P' => 7,           'R' => 9,
                  'S' => 2, 'T' => 3, 'U' => 4, 'V' => 5, 'W' => 6, 'X' => 7, 'Y' => 8, 'Z' => 9
    );

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        return strlen($this->number) === parent::LENGTH
            && $this->validateCharacters()
            && $this->validateCheckDigit();
    }

    /**
     * Validate that only valid characters are use (excludes i, o, q)
     *
     * @return bool
     */
    protected function validateCharacters()
    {
        // I, O, Q not used anywhere
        $ioq = '[a-hj-npr-z0-9]';
        // 0-9 and X for check digit
        $check = '[0-9x]';
        // U, Z, 0 not used in model year
        $uz0 = '[a-hj-npr-tv-y1-9]';
        return (bool) preg_match(
            '/^' . $ioq . '{8}' . $check . $uz0 . $ioq . '{7}$/i',
            $this->number
        );
    }

    /**
     * Validate that the check digit matches
     *
     * @return bool
     */
    protected function validateCheckDigit()
    {
        $number = $this->number;
        $sum = 0;
        for ($i = 0; $i < strlen($number); $i++) {
            $value = is_numeric($number[$i])
                ? $number[$i]
                : self::$map[$number[$i]];

            $sum += $value * self::$weights[$i];
        }

        $checkDigit = $sum % 11;
        if ($checkDigit === 10) {
            $checkDigit = 'X';
        }

        return $number[8] === (string) $checkDigit;
    }

    /**
     * {@inheritdoc}
     */
    public function year()
    {
        $years = array(
            'A' => array(1980, 2010),
            'B' => array(1981, 2011),
            'C' => array(1982, 2012),
            'D' => array(1983, 2013),
            'E' => array(1984, 2014),
            'F' => array(1985, 2015),
            'G' => array(1986, 2016),
            'H' => array(1987, 2017),
            'J' => array(1988, 2018),
            'K' => array(1989, 2019),
            'L' => array(1990, 2020),
            'M' => array(1991, 2021),
            'N' => array(1992, 2022),
            'P' => array(1993, 2023),
            'R' => array(1994, 2024),
            'S' => array(1995, 2025),
            'T' => array(1996, 2026),
            'V' => array(1997, 2027),
            'W' => array(1998, 2028),
            'X' => array(1999, 2029),
            'Y' => array(2000, 2030),
            '1' => array(2001, 2031),
            '2' => array(2002, 2032),
            '3' => array(2003, 2033),
            '4' => array(2004, 2034),
            '5' => array(2005, 2035),
            '6' => array(2006, 2036),
            '7' => array(2007, 2037),
            '8' => array(2008, 2038),
            '9' => array(2009, 2039)
        );

        if (array_key_exists($this->vis[0], $years)) {
            return $years[$this->vis[0]];
        }
        return array();
    }
}
