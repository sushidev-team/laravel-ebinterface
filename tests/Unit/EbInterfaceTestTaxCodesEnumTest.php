<?php

namespace AMBERSIVE\Ebinterface\Tests\Unit;

use Ambersive\Ebinterface\Enums\TaxCodes;

use AMBERSIVE\Tests\TestCase;

class EbInterfaceTestTaxCodesEnumTest extends TestCase
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
     * Test if CODES contains a list of items
     */
    public function testIfEnumCodesReturnsArray(): void {

        $result = TaxCodes::CODES();
        
        $this->assertNotNull($result);
        $this->assertTrue(is_array($result->toArray()));
        $this->assertNotEmpty(is_array($result->toArray()));

    }

    /**
     * Test if TAXRATES contains a list of items
     */
    public function testIfEnumTaxRatesReturnsArray(): void {

        $result = TaxCodes::TAXRATES();
        
        $this->assertNotNull($result);
        $this->assertTrue(is_array($result->toArray()));
        $this->assertNotEmpty(is_array($result->toArray()));

    }

    /**
     * Test if FURTHERIDENTIFICATION contains a list of items
     */
    public function testIfEnumFurtherIdentificationReturnsArray(): void {

        $result = TaxCodes::FURTHERIDENTIFICATION();
        
        $this->assertNotNull($result);
        $this->assertTrue(is_array($result->toArray()));
        $this->assertNotEmpty(is_array($result->toArray()));

    }

}