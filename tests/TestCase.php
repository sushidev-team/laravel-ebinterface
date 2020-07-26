<?php

namespace AMBERSIVE\Tests;

use Illuminate\Contracts\Console\Kernel;

use Orchestra\Testbench\TestCase as Orchestra;

use Ambersive\Ebinterface\EbinterfaceServiceProvider;
use Spatie\ArrayToXml\ArrayToXml;

use Config;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;

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

    /**
     * Create a mock for the api calls
     *
     * @param  mixed $responses
     * @return void
     */
    protected function createApiMock(array $responses = [])
    {

        $mock    = new MockHandler(array_map(function($item){
            return $item->get();
        }, $responses));

        $handler = HandlerStack::create($mock);

        return new Client(['handler' => $handler]);

    }
}
