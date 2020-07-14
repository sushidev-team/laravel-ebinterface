<?php

namespace AMBERSIVE\Ebinterface\Tests\Unit;

use Carbon\Carbon;

use Ambersive\Ebinterface\Models\EbInterfaceAddress;
use Ambersive\Ebinterface\Models\EbInterfaceInvoiceDelivery;

use AMBERSIVE\Tests\TestCase;

class EbInterfaceDeliveryTest extends TestCase
{

    public EbINterfaceAddress $address;

    protected function setUp(): void
    {
        parent::setUp();
        $this->address = new EbInterfaceAddress("Manuel Pirker-Ihl", "Geylinggasse 15", "Vienna", "1130", "AT");
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }
    
    /**
     * Test if the delivery toXml contains a Date object
     */
    public function testIfEbInterfaceDeliveryConvertToXmlWillBeValid():void {

        $delivery = new EbInterfaceInvoiceDelivery($this->address, Carbon::now());
        $xml = $delivery->toXml();

        $this->assertNotNull($delivery);
        $this->assertNotNull($xml);
        $this->assertNotFalse(strpos($xml, "<Date>".Carbon::now()->format('Y-m-d')."</Date>"));
        $this->assertFalse(strpos($xml, "&lt;"));

    }

}