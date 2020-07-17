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

}