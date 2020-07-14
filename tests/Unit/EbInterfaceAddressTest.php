<?php

namespace AMBERSIVE\Ebinterface\Tests\Unit;

use Config;
use File;

use Ambersive\Ebinterface\Models\EbInterfaceAddress;

use AMBERSIVE\Tests\TestCase;

class EbInterfaceAddressTest extends TestCase
{

    public EbInterface $interface;

    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }
    
    /**
     * An exception should be thrown
     */
    public function testIfInvoiceAddressWillRequireAValidCountryCode():void {

        $this->expectException(\Illuminate\Validation\ValidationException::class);

        $address = new EbInterfaceAddress("Manuel Pirker-Ihl", "Geylinggasse 15", "Vienna", "1130", "XX");

    }

}