<?php
namespace PhillipsData\Vin\Reader;

/**
 * ISO 3779 is the basis for Vehicle Identification Numbers
 */
abstract class Iso3779 implements ReaderInterface
{
    /**
     * @var int The length of VIN as defined by ISO 3779
     */
    const LENGTH = 17;

    /**
     * @var string The VIN
     */
    protected $number;
    /**
     * @var string The World manufacturer identifier
     */
    protected $wmi;
    /**
     * @var string The vehicle descriptor section
     */
    protected $vds;
    /**
     * @var string The vehicle identifier section
     */
    protected $vis;
    /**
     * @var array A map of partial WMIs to ISO 3166 country codes
     */
    protected $countries = array();

    /**
     * {@inheritdoc}
     */
    public function number($number)
    {
        $this->number = strtoupper($number);
        if (strlen($number) === self::LENGTH) {
            $this->wmi = substr($number, 0, 3);
            $this->vds = substr($number, 3, 6);
            $this->vis = substr($number, 9, 8);
        }

        $this->expandCountries();
    }

    /**
     * {@inheritdoc}
     */
    public function country()
    {
        if (null === $this->wmi) {
            return null;
        }

        $countryId = $this->wmi[0] . $this->wmi[1];
        if (array_key_exists($countryId, $this->countries)) {
            return $this->countries[$countryId];
        }
        return null;
    }

    /**
     * Builds a mapping of partial WMIs to ISO 3166 country codes
     */
    protected function expandCountries()
    {
        $countries = array(
            array('AA', 'AH', 'ZA'),
            array('AJ', 'AN', 'CI'),
            array('AP', 'A0', null),
            array('BA', 'BE', 'AO'),
            array('BF', 'BK', 'KE'),
            array('BL', 'BR', 'TZ'),
            array('BS', 'B0', null),
            array('CA', 'CE', 'BJ'),
            array('CF', 'CK', 'MG'),
            array('CL', 'CR', 'TN'),
            array('CS', 'C0', null),
            array('DA', 'DE', 'EG'),
            array('DF', 'DK', 'MA'),
            array('DL', 'DR', 'ZM'),
            array('DS', 'D0', null),
            array('EA', 'EE', 'ET'),
            array('EF', 'EK', 'MZ'),
            array('EL', 'E0', null),
            array('FA', 'FE', 'GH'),
            array('FF', 'FK', 'NG'),
            array('FL', 'F0', null),
            array('GA', 'G0', null),
            array('HA', 'H0', null),
            array('JA', 'J0', 'JP'),
            array('KA', 'KE', 'LK'),
            array('KF', 'KK', 'IL'),
            array('KL', 'KR', 'KR'),
            array('KS', 'K0', 'KZ'),
            array('LA', 'L0', 'CN'),
            array('MA', 'ME', 'IN'),
            array('MF', 'MK', 'ID'),
            array('ML', 'MR', 'TH'),
            array('MS', 'M0', null),
            array('NA', 'NE', 'IR'),
            array('NF', 'NK', 'PK'),
            array('NL', 'NR', 'TR'),
            array('NS', 'N0', null),
            array('PA', 'PE', 'PH'),
            array('PF', 'PK', 'SG'),
            array('PL', 'PR', 'MY'),
            array('PS', 'P0', null),
            array('RA', 'RE', 'AE'),
            array('RF', 'RK', 'TW'),
            array('RL', 'RR', 'VN'),
            array('RS', 'R0', 'SA'),
            array('SA', 'SM', 'GB'),
            array('SN', 'ST', 'DE'),
            array('SU', 'SZ', 'PL'),
            array('S1', 'S4', 'LV'),
            array('S5', 'S0', null),
            array('TA', 'TH', 'CH'),
            array('TJ', 'TP', 'CZ'),
            array('TR', 'TV', 'HU'),
            array('TW', 'T1', 'PT'),
            array('T2', 'T0', null),
            array('UA', 'UG', null),
            array('UH', 'UM', 'DK'),
            array('UN', 'UT', 'IE'),
            array('UU', 'UZ', 'RO'),
            array('U1', 'U4', null),
            array('U5', 'U7', 'SK'),
            array('U8', 'U0', null),
            array('VA', 'VE', 'AT'),
            array('VF', 'VR', 'FR'),
            array('VS', 'VW', 'ES'),
            array('VX', 'V2', 'RS'),
            array('V3', 'V5', 'HR'),
            array('V6', 'V0', 'EE'),
            array('WA', 'W0', 'DE'),
            array('XA', 'XE', 'BG'),
            array('XF', 'XK', 'GR'),
            array('XL', 'XR', 'NL'),
            array('XS', 'XW', 'RU'),
            array('XX', 'X2', 'LU'),
            array('X3', 'X0', 'RU'),
            array('YA', 'YE', 'BE'),
            array('YF', 'YK', 'FI'),
            array('YL', 'YR', 'MT'),
            array('YS', 'YW', 'SE'),
            array('YX', 'Y2', 'NO'),
            array('Y3', 'Y5', 'BY'),
            array('Y6', 'Y0', 'UA'),
            array('ZA', 'ZR', 'IT'),
            array('ZS', 'ZW', null),
            array('ZX', 'Z2', 'SI'),
            array('Z3', 'Z5', 'LT'),
            array('Z6', 'Z0', null),
            array('1A', '10', 'US'),
            array('2A', '20', 'CA'),
            array('3A', '37', 'MX'),
            array('38', '30', 'KY'),
            array('4A', '40', 'US'),
            array('5A', '50', 'US'),
            array('6A', '6W', 'AU'),
            array('6X', '60', null),
            array('7A', '7E', 'NZ'),
            array('7F', '70', null),
            array('8A', '8E', 'AR'),
            array('8F', '8K', 'CL'),
            array('8L', '8R', 'EC'),
            array('8S', '8W', 'PE'),
            array('8X', '82', 'VE'),
            array('83', '80', null),
            array('9A', '9E', 'BR'),
            array('9F', '9K', 'CO'),
            array('9L', '9R', 'PY'),
            array('9S', '9W', 'UY'),
            array('9X', '92', 'TT'),
            array('93', '99', 'BR'),
            array('90', '90', null)
        );

        foreach ($countries as $country) {
            $start = $country[0];
            $end = $country[1];
            $this->countries[$start] = $country[2];

            while ($start != $end) {
                $start = $start[0] . $this->nextCountryToken($start[1]);

                $this->countries[$start] = $country[2];
            }
        }
    }

    /**
     * Returns the next token in the sequence of WMI country assignments
     *
     * @param string $token The character for which to find the next character in the sequence
     * @return string The next character in the sequence
     */
    private function nextCountryToken($token)
    {
        $valueMap = array(
            'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'J', 'K', 'L', 'M', 'N',
            'P', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', '1', '2', '3',
            '4', '5', '6', '7', '8', '9', '0'
        );
        $tokenMap = array_flip($valueMap);

        $index = ++$tokenMap[$token];

        if (array_key_exists($index, $valueMap)) {
            return $valueMap[$index];
        }
        return '0';
    }
}
