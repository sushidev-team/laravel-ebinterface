<?php

namespace AMBERSIVE\Ebinterface\Tests\Unit;

use Carbon\Carbon;

use Ambersive\Ebinterface\Models\EbInterfaceInvoiceLines;
use Ambersive\Ebinterface\Models\EbInterfaceInvoiceLine;

use AMBERSIVE\Tests\TestCase;

class EbInterfaceInvoiceLinesTest extends TestCase
{

    public EbInterfaceInvoiceLines $lines;

    protected function setUp(): void
    {
        parent::setUp();
        $this->lines = new EbInterfaceInvoiceLines();        
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }


    /**
     * Test if a line can be added
     */
    public function testIfInvoiceLineCanBeAdded():void {

        $this->lines->add(new EbInterfaceInvoiceLine());

        $this->assertNotNull($this->lines->lines);
        $this->assertNotEmpty($this->lines->lines);
        $this->assertEquals(1, $this->lines->count());

    }

    /**
     * Test if multiple lines can be added
     */
    public function testIfInvoiceLineCanAddMultipleLines(): void {

        $amount = rand(2, 10);
        $count = 0;

        while($count < $amount) {
            $this->lines->add(new EbInterfaceInvoiceLine());
            $count++;
        }

        $this->assertNotNull($this->lines->lines);
        $this->assertNotEmpty($this->lines->lines);
        $this->assertEquals($amount, $this->lines->count());

    }

    /**
     * Test if the add line method will accepts a callable as second param which will be 
     * passed after adding the line
     */
    public function testIfInvoiceAddMethodAlsoAcceptsACallableAsSecondParam(): void {

        $called = false;

        $this->lines->add(new EbInterfaceInvoiceLine(), function($line, $lineIndex) use (&$called) {

            $this->assertNotNull($line);
            $this->assertEquals(0, $lineIndex);

            $called = true;

        });

        $this->assertNotNull($this->lines->lines);
        $this->assertNotEmpty($this->lines->lines);
        $this->assertEquals(1, $this->lines->count());
        $this->assertTrue($called);

    }

    /**
     * Test a line be removed by using the index
     */
    public function testIfInvoiceLineCanBeRemoved(): void {

        $startCount = $this->lines->count();

        $this->lines->add(new EbInterfaceInvoiceLine());
        $countAfterAdding = $this->lines->count();

        $this->lines->remove(0);
        $endCount = $this->lines->count();

        $this->assertEquals(0, $startCount);
        $this->assertEquals(1, $countAfterAdding );
        $this->assertEquals(0, $endCount);

    }

    /**
     * Test if invalid lines will be filtered
     */
    public function testIfInvalidLinesWillBeFiltered(): void {

        $this->lines->add(new EbInterfaceInvoiceLine());
        $this->lines->add(new EbInterfaceInvoiceLine());

        $xml = $this->lines->toXml("ItemListItem");

        $this->assertNotNull($xml);

        $this->assertFalse(strpos($xml, "<HeaderDescription></HeaderDescription>"));
        $this->assertFalse(strpos($xml, "<FooterDescription></FooterDescription>"));

        $this->assertEquals("<ItemList></ItemList>", $xml);

    }

    /**
     * Test if the header from the item list can be set 
     */
    public function testIfInvoiceItemListCanHaveAHeaderDescription():void {

        $this->lines->setHeaderItemList("TEST 1");

        $xml = $this->lines->toXml("ItemListItem");

        $this->assertNotNull($xml);
        $this->assertEquals("<ItemList><HeaderDescription>TEST 1</HeaderDescription></ItemList>", $xml);
        $this->assertNotFalse(strpos($xml, "<HeaderDescription>TEST 1</HeaderDescription>"));

    }

    /**
     * Test if the footer from the item list can be set
     */
    public function testIfInvoiceItemListCanHaveAFooterDescription():void {

        $this->lines->setFooterItemList("TEST 2");

        $xml = $this->lines->toXml("ItemListItem");

        $this->assertNotNull($xml);
        $this->assertEquals("<ItemList><FooterDescription>TEST 2</FooterDescription></ItemList>", $xml);
        $this->assertNotFalse(strpos($xml, "<FooterDescription>TEST 2</FooterDescription>"));

    }

/**
     * Test if the header from the item list can be set 
     */
    public function testIfInvoiceItemListCanHaveAHeaderDescriptionOnGlobalLevel():void {

        $this->lines->setHeader("TEST 1");

        $xml = $this->lines->toXml("ItemListItem");

        $this->assertNotNull($xml);
        $this->assertEquals("<HeaderDescription>TEST 1</HeaderDescription><ItemList></ItemList>", $xml);
        $this->assertNotFalse(strpos($xml, "<HeaderDescription>TEST 1</HeaderDescription>"));

    }

    /**
     * Test if the footer from the item list can be set
     */
    public function testIfInvoiceItemListCanHaveAFooterDescriptionOnGlobalLevel():void {

        $this->lines->setFooter("TEST 2");

        $xml = $this->lines->toXml("ItemListItem");

        $this->assertNotNull($xml);
        $this->assertEquals("<ItemList></ItemList><FooterDescription>TEST 2</FooterDescription>", $xml);
        $this->assertNotFalse(strpos($xml, "<FooterDescription>TEST 2</FooterDescription>"));

    }

}