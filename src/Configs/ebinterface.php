<?php

return [

    /*
    |--------------------------------------------------------------------------
    | EbInterface Settings
    |--------------------------------------------------------------------------
    |
    */

    'testMode' => env('EBINTERFACE_TESTMODE', false),
    'wsdl'     => [
        'production' => "",
        'testing'    => "https://test.erechnung.gv.at/files/ws/erb-in-test-order-102.wsdl"
    ],
    'biller' => [
        'vatId'             => env('EBINTERFACE_BILLER_VATID', null),
        'name'              => env('EBINTERFACE_BILLER_NAME', null),
        'street'            => env('EBINTERFACE_BILLER_STREET', null),
        'postal'            => env('EBINTERFACE_BILLER_POSTAL', null),
        'town'              => env('EBINTERFACE_BILLER_TOWN', null),
        'countryCode'       => env('EBINTERFACE_BILLER_COUNTRYCODE', null),
        'email'             => env('EBINTERFACE_BILLER_EMAIL', null),
        'salutation'        => env('EBINTERFACE_BILLER_SALUTATION', null),
        'salutation_name'   => env('EBINTERFACE_BILLER_SALUTATION_NAME', null),
    ]

];
