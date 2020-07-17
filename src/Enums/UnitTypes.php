<?php 

namespace Ambersive\Ebinterface\Enums;

use MyCLabs\Enum\Enum;

/**
 * Based on the recommendation
 * this list provides a full list of http://www.ebinterface.at/download/documentation/ebInvoice_4p3.pdf
 */

class UnitTypes extends Enum
{
    private const WEIGHT = [
        'MGM', // milligram
        'GRM', // gram
        'DJ',  // decagram
        'KGM', // kilogramme
        'TNE', // ton
    ];

    private const LENGTH = [
        'MMT', // milimetre
        'CMT', // centimetre
        'DMT', // decimetre
        'MTR', // metre
        'KTM', // kilometre
        'MMK', // square milimetre
        'CMK', // square centimetre
        'DMK', // square decimetre
        'MTK', // sqare metre
        'HAR', // hectare
        'KMK', // square kilometre
    ];

    private const VOLUME = [
        'MMQ', // cubic millimetre
        'CMQ', // cubic centrimetre
        'DMQ', // cubic decimetre
        'MTQ', // cubic metre
        'LTR', // litre
    ];

    private const NUMERIC = [
        'STK', // piece
        'C62', // one piec
        'LS',  // lump sum - pauschal
        'NAR', // number of articles
        'NPR', // number of pairs
        'P1',  // percent
        'SET', // set
        'PK',  // pack
    ];

    private const FILESIZE = [
        'A99', // bit
        'AD',  // byte
        '2P',  // kilobyte
        '4L',  // megabyte
        'E34', // gigabyte
        'E35', // terabyte
        'E36', // petabyte
    ];

    private const CURRENCY = [
        'EUR',  // euro
    ];

    private const TIME = [
        'LH',  // hour, labour hour
        'SEC', // second
        'MIN', // minute
        'HUR', // hour
        'DAY', // day
        'WEE', // week
        'MON', // month
        'QAN', // quarter
        'ANN', // year
    ];

    private const ENERGY = [
        'KWH', // kilowatt hour
    ];

}