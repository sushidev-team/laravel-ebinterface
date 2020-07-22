<?php

namespace AMBERSIVE\Ebinterface\Tests\Unit;

use Carbon\Carbon;

use Ambersive\Ebinterface\Models\EbInterfaceAddress;
use Ambersive\Ebinterface\Models\EbInterfaceContact;
use Ambersive\Ebinterface\Models\EbInterfaceInvoiceDelivery;

use AMBERSIVE\Tests\TestCase;

class EbInterfaceDeliveryTest extends TestCase
{

    public EbINterfaceAddress $address;
    public EbInterfaceContact $contact;

    protected function setUp(): void
    {
        parent::setUp();
        $this->address = new EbInterfaceAddress("Manuel Pirker-Ihl", "Geylinggasse 15", "Vienna", "1130", "AT");
        $this->contact = new EbInterfaceContact("Mr", "Manuel Pirker-Ihl");
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }
    
    /**
     * Test if the delivery toXml contains a Date object
     */
    public function testIfEbInterfaceDeliveryConvertToXmlWillBeValid():void {

        $delivery = new EbInterfaceInvoiceDelivery(Carbon::now(), $this->address, $this->contact);
        $xml = $delivery->toXml();

        $this->assertNotNull($delivery);
        $this->assertNotNull($xml);
        $this->assertNotFalse(strpos($xml, "<Date>".Carbon::now()->format('Y-m-d')."</Date>"));
        $this->assertFalse(strpos($xml, "&lt;"));
        $this->assertNotFalse(strpos($xml, "<Salutation>Mr</Salutation>"));

    }

    /**
     * Test if the delivery block accepts a null as contact block
     */
    public function testIfEbInterfaceDeliveryWillAcceptANullContactInformation():void {


        $delivery = new EbInterfaceInvoiceDelivery(Carbon::now(), $this->address);
        $xml = $delivery->toXml();

        $this->assertNotNull($delivery);
        $this->assertNotNull($xml);
        $this->assertNotFalse(strpos($xml, "<Date>".Carbon::now()->format('Y-m-d')."</Date>"));
        $this->assertFalse(strpos($xml, "&lt;"));
        $this->assertFalse(strpos($xml, "<Salutation>Mr</Salutation>"));

    }

    public function testIfEbInterfaceDeliveryWillNotHaveADeliveryWrapper(): void {

        $delivery = new EbInterfaceInvoiceDelivery(Carbon::now(), $this->address);
        $xml = $delivery->toXml("root");

        $this->assertFalse(strpos($xml, "<Delivery>"));

    }

}