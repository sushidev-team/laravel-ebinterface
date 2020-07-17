<?php 

namespace Ambersive\Ebinterface\Enums;

use MyCLabs\Enum\Enum;

/**
 * Based on the recommendation
 * this list provides a full list of http://www.ebinterface.at/download/documentation/ebInvoice_4p3.pdf
 */

class TaxCodes extends Enum
{
    
    private const CODES = [
        'S67', // tax frre based on §6 Abs 1 Z 27 EStG
        'S69', // tax frre based on §6 Abs 1 Z 9 EStG - gambling
        'IGL', // EU / intra-Community acquisition
        'RCH', // reverse charge (§19 Abs 1 UStG)
        'SA7', // Export into 3rd party countries ($7 UStG)
        'IGLDE', // $4 Nr 1b i.V.m §6a UStG
        'DB', // §24 UStG
        'RL', // §23 UStG
    ];

    private const TAXRATES = [
        'AT022', // normal tax code for Austria (20%)
        'AT029', // reduced tax rate (10%)
        'AT025', // wine (12%)
        'AT037', // wood (19%)
        'AT052', // (10%) additional tax for lump sum for forestry
        'AT038', // (8%) additional tax for lump sum for forestry
        'ATXXX', // (0%) / no tax
    ];

    private const FURTHERIDENTIFICATION = [
        'FN', // commercal register number
        'FR', // number in comercial register
        'ARA', // ARA number
        'DVR', // DVR number
    ];

}