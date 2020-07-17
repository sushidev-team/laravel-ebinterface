<?php 

namespace Ambersive\Ebinterface\Enums;

use MyCLabs\Enum\Enum;

/**
 * Based on the recommendation
 * this list provides a full list of https://www.wko.at/service/netzwerke/ebInvoice_5p0.pdf
 */

class TaxCodes extends Enum
{

    private const TAXRATES = [
        'S',  // normal tax code for Austria (20%)
        'AA', // reduced tax rate (10%, 13& etc.)
        'O',  // no tax possible
        'D',  // reliefed for tax
        'AE', // reverse charge
    ];

    private const FURTHERIDENTIFICATION = [
        'FN', // commercal register number
        'HG', // commercial court name
        'ARA', // ARA number
        'DVR', // DVR number
        'Contract', // Contract Number
        'VN', // society registre number
    ];

    /**
     * Will return all enum values
     *
     * @return array
     */
    public static function getAll(): array {

        return [
            ...self::CODES,
            ...self::TAXRATES,
            ...self::FURTHERIDENTIFICATION
        ];

    }

}