<?php

namespace AMBERSIVE\Ebinterface\Tests\Unit;

use Tests\TestCase;

use Config;
use File;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Ambersive\Ebinterface\Classes\EbInterfaceInvoiceHandler;
use Ambersive\Ebinterface\Classes\EbInterfaceInvoice;

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
    
    public function testIfInvoiceHandlerCreateWillReturnInvoiceClass(): void {

        $invoice = $this->invoiceHandler->create();

        $this->assertTrue($invoice instanceof EbInterfaceInvoice);

        dd($invoice);

    }

}