<?php

namespace AMBERSIVE\Ebinterface\Tests\Unit;

use Config;
use File;

use Ambersive\Ebinterface\Classes\EbInterface;
use Ambersive\Ebinterface\Models\EbInterfaceTax;

use AMBERSIVE\Tests\TestCase;

class EbInterfaceTaxTest extends TestCase
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
     * Test if tax item can be generated an will return the given attributes
     */
    public function testIfTaxItemCanBeCreated(): void {

        $tax = new EbInterfaceTax('S', 20, 100.0);

        $this->assertNotNull($tax);
        $this->assertEquals("S", $tax->type);
        $this->assertEquals(20.0, $tax->percent);
        $this->assertEquals(100.0, $tax->value);

    }

    /** 
     * Test if the tax item will validate the type
     */
    public function testIfTaxItemCreationWillThrowValidationExeception(): void {

        $this->expectException(\Illuminate\Validation\ValidationException::class);
        $tax = new EbInterfaceTax('XX', 20, 100.0);

    }

    /**
     * Test if the class has method which will calculate the tax value
     */
    public function testIfTaxItemHasCalculatedValue(): void {

        $tax = new EbInterfaceTax('S', 20, 100.0);

        $this->assertEquals(20, $tax->getTax());

    }

    /**
     * Test if the Tax class accepts a callable as third parameter
     */
    public function testIfTaxItemAcceptsACallable():void {

        $tax = new EbInterfaceTax('S', 20, function($t){
            return 1000;
        });

        $this->assertEquals(200, $tax->getTax());

    }

    /**
     * Test if the tax item 
     */
    public function testIfTaxItemHasDefaultValues(): void {

        $tax = new EbInterfaceTax();

        $this->assertNotNull($tax);
        $this->assertEquals("S", $tax->type);
        $this->assertEquals(20.0, $tax->percent);
        $this->assertEquals(0.0, $tax->value);

    }

    /**
     * Test if the tax item has method to set the value that should be taxable
     */
    public function testIfTaxItemHasMethodToSetValue(): void {

        $tax = new EbInterfaceTax();
        $tax->setValue(1000);

        $this->assertEquals(1000.0, $tax->value);

    }

    /**
     * Test if the setValue also accepts callable
     */
    public function testIfTaxItemHasMethodToSetValueAndAcceptsCallable():void {

        $tax = new EbInterfaceTax();
        $tax->setValue(function($t) {
            return 1000;
        });

        $this->assertEquals(1000.0, $tax->value);

    }

    /**
     * Test if the addValue will add an amount
     */
    public function testIfTaxItemHasMethodToAddAmountToCurrentValue(): void {

        $tax = new EbInterfaceTax();
        $tax->addValue(1000);
        $tax->addValue(1000);
        $this->assertEquals(2000.0, $tax->value);

    }

    /**
     * Test if the toXml method generates a correct xml part
     */
    public function testIfTaxGenerateCorrectOutput(): void {

        $tax = new EbInterfaceTax();

        $xml = $tax->toXml();
        $this->assertEquals("<TaxItem><TaxableAmount>0.00</TaxableAmount><TaxPercent TaxCategoryCode='S'>20.00</TaxPercent></TaxItem>", $xml);

    }

    /**
     * Test if the toXml method can also skip the parent item
     */
    public function testIfTaxToXmlCanRemoveTheParent(): void {

        $tax = new EbInterfaceTax();

        $xml = $tax->toXml("root");
        $this->assertEquals("<TaxableAmount>0.00</TaxableAmount><TaxPercent TaxCategoryCode='S'>20.00</TaxPercent>", $xml);


    }

}