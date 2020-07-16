<?php

namespace AMBERSIVE\Ebinterface\Tests\Unit;

use Config;
use File;

use Carbon\Carbon;

use Ambersive\Ebinterface\Classes\EbInterfaceInvoiceHandler;
use Ambersive\Ebinterface\Models\EbInterfaceInvoice;
use Ambersive\Ebinterface\Models\EbInterfaceInvoiceBiller;

use Ambersive\Ebinterface\Models\EbInterfaceAddress;
use Ambersive\Ebinterface\Models\EbInterfaceContact;

use AMBERSIVE\Tests\TestCase;

class EbInterfaceInvoiceHandlerTest extends TestCase
{

    public EbInterfaceInvoiceHandler $invoiceHandler;
    public EbInterfaceInvoice $invoice;

    public $address;
    public $contact;

    protected function setUp(): void
    {
        parent::setUp();
        $this->invoiceHandler = new EbInterfaceInvoiceHandler();
        $this->invoice = $this->invoiceHandler->create();

        // Test data
        $this->address = new EbInterfaceAddress("Manuel Pirker-Ihl", "Geylinggasse 15", "Vienna", "1130", "AT", "office@ambersive.com");
        $this->contact = new EbInterfaceContact("Mr", "Manuel Pirker-XXX");

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

    /**
     * Test if the invoice class has an "toArray" method which will reeturn
     * valid data and not an empty array
     */
    public function testIfInvoiceClassHasAnWorkingToArrayMethod():void {

        $data = $this->invoice->toArray();

        $this->assertNotNull($data);
        $this->assertNotEmpty($data);

    }

    /**
     * Test if he invoice date can be changed by calling the method
     */
    public function testIfInvoiceSetInvoiceDateWillChangeTheInvoiceDate():void {

        $date = $this->invoice->invoiceDate->copy();
        $this->invoice->setInvoiceDate(Carbon::now()->addYear(1));
        
        $this->assertFalse($date->isSameDay($this->invoice->invoiceDate));

    }

    /**
     * Test if the setBiller method accepts a callable
     */
    public function testIfInvoiceSetBillerCanContainACallable():void {

        $this->invoice->setBiller(function($invoice) {
            return new EbInterfaceInvoiceBiller(
                $this->address,
                $this->contact
            );
        });

        $this->assertNotNull($this->invoice->biller);
        $this->assertEquals("Manuel Pirker-XXX", $this->invoice->biller->contact->name);

    }

    /**
     * Tet if the setBiller method accepts an EbInterfaceInvoiceBiller as parameter
     */
    public function testIfInvoiceSetBillerAcceptsAnInvoiceBillerClass():void {

        $this->invoice->setBiller(new EbInterfaceInvoiceBiller(
            $this->address,
            $this->contact
        ));

        $this->assertNotNull($this->invoice->biller);
        $this->assertEquals("Manuel Pirker-XXX", $this->invoice->biller->contact->name);

    }

}   