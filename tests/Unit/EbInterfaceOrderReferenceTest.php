<?php

namespace AMBERSIVE\Ebinterface\Tests\Unit;

use Carbon\Carbon;

use Ambersive\Ebinterface\Models\EbInterfaceOrderReference;

use AMBERSIVE\Tests\TestCase;

class EbInterfaceOrderReferenceTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }


    public function testIfInvoiceOrderReferenceCanBeGenerated():void {

        $reference = new EbInterfaceOrderReference("TEST", Carbon::now(), "TESTORDER");
        $this->assertNotNull($reference);

    }

    public function testIfInvoiceOrderReferenceHasXmlFunction():void {

        $reference = new EbInterfaceOrderReference("TEST", Carbon::now(), "TESTORDER");
        $this->assertNotNull($reference);
        $xml = $reference->toXml();

        $this->assertNotNull($xml);
        $this->assertNotFalse(strpos($xml,"<OrderID>TEST</OrderID>"));

    }

}