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

}