<?php

namespace AMBERSIVE\Tests;

use Illuminate\Contracts\Console\Kernel;

use Orchestra\Testbench\TestCase as Orchestra;

use Ambersive\Ebinterface\EbinterfaceServiceProvider;
use Spatie\ArrayToXml\ArrayToXml;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            EbinterfaceServiceProvider::class,
            \Intervention\Validation\Laravel\ValidationServiceProvider::class
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            
        ];
    }
}
