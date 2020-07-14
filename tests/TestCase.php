<?php

namespace AMBERSIVE\Tests;

use Illuminate\Contracts\Console\Kernel;

use Orchestra\Testbench\TestCase as Orchestra;

use Ambersive\Ebinterface\EbinterfaceServiceProvider;
use Tariq86\CountryList\CountryListServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            EbinterfaceServiceProvider::class,
            CountryListServiceProvider::class
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Countries' => 'Tariq86\CountryList\CountryListFacade',
        ];
    }
}
