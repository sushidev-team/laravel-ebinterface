<?php

namespace AMBERSIVE\Ebinterface\Tests\Unit;

use Carbon\Carbon;

use Ambersive\Ebinterface\Models\EbInterfaceInvoiceLine;

use AMBERSIVE\Tests\TestCase;

class EbInterfaceInvoiceLineTest extends TestCase
{

    public EbInterfaceInvoiceLine $line;

    protected function setUp(): void
    {
        parent::setUp();
        $this->line = new EbInterfaceInvoiceLine();        
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * Test if the description of the line can be set
     */
    public function testIfInvoiceLineCanSetDescription(): void {

        $current = $this->line->description;

        $this->line->setDescription("TEST");
        
        // Tests
        $this->assertNotEquals($current, $this->line->description);
        $this->assertEquals("TEST", $this->line->description);

    }

    /**
     * Test if the quantity can be set
     */
    public function testIfInvoiceLineCanSetTheQuantity(): void {

        $currentQuantityType = $this->line->quantityType;
        $currentQuantity = $this->line->quantity;

        $this->line->setQuantity("STK", 10);
        
        // Tests
        $this->assertNotEquals($currentQuantityType, $this->line->quantityType);
        $this->assertEquals("STK", $this->line->quantityType);
        $this->assertNotEquals($currentQuantity, $this->line->quantity);
        $this->assertEquals(10, $this->line->quantity);

    }

    /**
     * Test if the unit price can be set
     */
    public function testIfInvoiceLineCanSetTheUnitPrice(): void {

        $current = $this->line->unitPrice;

        $this->line->setUnitPrice(2);
        
        // Tests
        $this->assertNotEquals($current, $this->line->unitPrice);
        $this->assertEquals(2, $this->line->unitPrice);

    }

    /**
     * Test if the article nr can be set
     */
    public function testIfInvoiceLineCanSetArticleNr(): void {

        $current = $this->line->articleNr;

        $this->line->setArticleNr("TEST12");
        
        // Tests
        $this->assertNotEquals($current, $this->line->articleNr);
        $this->assertEquals("TEST12", $this->line->articleNr);

    }

}