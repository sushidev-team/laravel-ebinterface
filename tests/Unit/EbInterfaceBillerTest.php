<?php

namespace AMBERSIVE\Ebinterface\Tests\Unit;

use Carbon\Carbon;

use Ambersive\Ebinterface\Models\EbInterfaceAddress;
use Ambersive\Ebinterface\Models\EbInterfaceContact;
use Ambersive\Ebinterface\Models\EbInterfaceInvoiceDelivery;

use AMBERSIVE\Tests\TestCase;

class EbInterfaceBillerTest extends TestCase
{

    public EbINterfaceAddress $address;
    public EbInterfaceContact $contact;

    protected function setUp(): void
    {
        parent::setUp();
        $this->address = new EbInterfaceAddress("Manuel Pirker-Ihl", "Geylinggasse 15", "Vienna", "1130", "AT", "office@ambersive.com");
        $this->contact = new EbInterfaceContact("Mr", "Manuel Pirker-Ihl");
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    public function testIfEbInterfaceBillerHasAnEmailAttribute():void {

        $this->assertNotNull($this->address);
        $this->assertNotNull($this->address->email);

    }

}