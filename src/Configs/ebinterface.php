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
    ]

];
