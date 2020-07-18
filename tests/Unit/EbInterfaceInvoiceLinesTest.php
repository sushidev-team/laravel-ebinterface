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

    public function testIfInvoiceToXmlWillCreateValidXML(): void {

        $this->lines->add(new EbInterfaceInvoiceLine());
        $this->lines->add(new EbInterfaceInvoiceLine());

        $xml = $this->lines->toXml("ItemListItem");

        $this->assertNotNull($xml);

        $this->assertNotFalse(strpos($xml, "<HeaderDescription></HeaderDescription>"));
        // TODO: Add missing tests

    }

}