<?php

namespace AMBERSIVE\Ebinterface\Tests\Unit;

use Tests\TestCase;

use Config;
use File;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Ambersive\Ebinterface\Classes\EbInterface;

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