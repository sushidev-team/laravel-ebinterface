<?php

namespace AMBERSIVE\Ebinterface\Tests\Unit;

use Config;
use File;

use Ambersive\Ebinterface\Classes\EbInterface;

use AMBERSIVE\Tests\TestCase;

class EbInterfaceTest extends TestCase
{

    public EbInterface $interface;

    protected function setUp(): void
    {
        parent::setUp();
        $this->interface = new EbInterface("https://test.erechnung.gv.at/files/ws/erb-in-test-order-102.wsdl");
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }
    
    /**
     * Test if the connection to the WSDL Service from the Austrian Government works
     */
    public function testIfEbInterfaceSoapClientWorks():void {
        $this->assertNotEquals(0, sizeOf($this->interface->client->__getFunctions()));
    }

}