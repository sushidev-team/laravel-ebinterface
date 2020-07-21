<?php

namespace AMBERSIVE\Ebinterface\Tests\Unit;


use Ambersive\Ebinterface\Models\EbInterfaceDiscount;

use AMBERSIVE\Tests\TestCase;

class EbInterfaceDiscountTest extends TestCase
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
     * Test if the discount object requires to params
     */
    public function testIfInvoiceDiscountRequiresTwoParams(): void {

        $this->expectException(\ArgumentCountError::class);   
        $discount = new EbInterfaceDiscount();

    }

    /**
     * Test if the given params were stored
     */
    public function testIfInvoiceDiscountCanStoreTheGivenValues():void {

        $discount = new EbInterfaceDiscount(now(), 10);

        $this->assertNotNull($discount->date);
        $this->assertNotNull($discount->percent);
        $this->assertEquals(10, $discount->percent);

    }

    /**
     * Test if the array will be created correctly
     */
    public function testIfInvoiceDiscountToArrayCreatesCorrectArray(): void {

        $discount = new EbInterfaceDiscount(now(), 10);
        $result = $discount->toArray();

        $this->assertNotNull($result);
        $this->assertNotEmpty($result);
        $this->assertEquals(10, $result['Percentage']);

    }

    /**
     * Test if the xml output for an discount is correct
     */
    public function testIfInvoiceDiscountToXmlWillCreateCorrectXml(): void {


        $discount = new EbInterfaceDiscount(now(), 10);
        $xml = $discount->toXml("root");

        $this->assertNotNull($xml);
        $this->assertEquals("<PaymentDate>".now()->format("Y-m-d")."</PaymentDate><Percentage>10</Percentage>", $xml);

    }

    /**
     * Test if the xml output for an discount is correct
     */
    public function testIfInvoiceDiscountToXmlWillCreateCorrectXmlWithContainer(): void {


        $discount = new EbInterfaceDiscount(now(), 10);
        $xml = $discount->toXml();

        $this->assertNotNull($xml);
        $this->assertEquals("<Discount><PaymentDate>".now()->format("Y-m-d")."</PaymentDate><Percentage>10</Percentage></Discount>", $xml);

    }

}