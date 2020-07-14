<?php

namespace AMBERSIVE\Ebinterface\Tests\Unit;

use Config;
use File;

use Ambersive\Ebinterface\Classes\EbInterfaceInvoiceHandler;
use Ambersive\Ebinterface\Models\EbInterfaceInvoice;

use AMBERSIVE\Tests\TestCase;

class EbInterfaceInvoiceHandlerTest extends TestCase
{

    public EbInterfaceInvoiceHandler $invoiceHandler;

    protected function setUp(): void
    {
        parent::setUp();
        $this->invoiceHandler = new EbInterfaceInvoiceHandler();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }
    
    /**
     * Test if an instance of invoice will be returned by the EbInterfaceInvoiceHandler
     */
    public function testIfInvoiceHandlerCreateWillReturnInvoiceClass(): void {

        $invoice = $this->invoiceHandler->create();

        $this->assertNotNull($invoice);
        $this->assertTrue($invoice instanceof EbInterfaceInvoice);

    }

}