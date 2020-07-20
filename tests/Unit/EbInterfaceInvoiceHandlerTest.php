<?php

namespace AMBERSIVE\Ebinterface\Tests\Unit;

use Config;
use File;

use Carbon\Carbon;

use Ambersive\Ebinterface\Classes\EbInterfaceInvoiceHandler;
use Ambersive\Ebinterface\Models\EbInterfaceInvoice;
use Ambersive\Ebinterface\Models\EbInterfaceInvoiceBiller;
use Ambersive\Ebinterface\Models\EbInterfaceInvoiceDelivery;
use Ambersive\Ebinterface\Models\EbInterfaceInvoiceRecipient;
use Ambersive\Ebinterface\Models\EbInterfaceCompanyLegal;
use Ambersive\Ebinterface\Models\EbInterfaceInvoiceLines;

use Ambersive\Ebinterface\Models\EbInterfaceAddress;
use Ambersive\Ebinterface\Models\EbInterfaceContact;
use Ambersive\Ebinterface\Models\EbInterfaceTax;

use AMBERSIVE\Tests\TestCase;

class EbInterfaceInvoiceHandlerTest extends TestCase
{

    public EbInterfaceInvoiceHandler $invoiceHandler;
    public EbInterfaceInvoice $invoice;

    public $address;
    public $contact;
    public $legal;

    protected function setUp(): void
    {
        parent::setUp();
        $this->invoiceHandler = new EbInterfaceInvoiceHandler();
        $this->invoice = $this->invoiceHandler->create();

        // Test data
        $this->address = new EbInterfaceAddress("Manuel Pirker-Ihl", "Geylinggasse 15", "Vienna", "1130", "AT", "office@ambersive.com");
        $this->contact = new EbInterfaceContact("Mr", "Manuel Pirker-XXX");
        $this->legal = new EbInterfaceCompanyLegal();

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

    /**
     * Test the delivery section of the invoice
     */
    public function testIfInvoiceSetDeliveryAcceptsACallable():void {

        $this->invoice->setDelivery(function($invoice) {
            return new EbInterfaceInvoiceDelivery(
                Carbon::now(),
                $this->address->setEmail("office@ambersive.com"),
                $this->contact
            );
        });

        $this->assertNotNull($this->invoice->delivery);

    }

    /**
     * Test if the invoice will accept the delivery object directly
     */
    public function testIfInvoiceSetDeliveryAcceptsDeliveryClass():void {

        $this->invoice->setDelivery(new EbInterfaceInvoiceDelivery(
            Carbon::now(),
            $this->address->setEmail("office@ambersive.com"),
            $this->contact
        ));

        $this->assertNotNull($this->invoice->delivery);

    }

    /**
     * Test if the invoice will accept the recipient as callable
     */
    public function testIfInvoiceSetRecipientAcceptCallable(): void {

        $this->invoice->setRecipient(function($invoice){
            return new EbInterfaceInvoiceRecipient(
                $this->legal,
                $this->address,
                $this->contact
            );
        });

        $this->assertNotNull($this->invoice->recipient);

    }

    /**
     * Test if the invoice will accept the recipient as callable
     */
    public function testIfInvoiceSetRecipientAcceptObject(): void {

        $this->invoice->setRecipient(new EbInterfaceInvoiceRecipient(
            $this->legal,
            $this->address,
            $this->contact
        ));

        $this->assertNotNull($this->invoice->recipient);

    }

    /**
     * Test if you can set the header
     */
    public function testIfInvoiceSetHeaderWorks():void {

        $this->invoice->setHeader("XXX");

        $this->assertNotNull($this->invoice->header);
        $this->assertEquals("XXX", $this->invoice->header);

    }

    /**
     * Test if you can set the footer
     */
    public function testIfInvoiceSetFooterWorks():void {

        $this->invoice->setFooter("YYY");

        $this->assertNotNull($this->invoice->footer);
        $this->assertEquals("YYY", $this->invoice->footer);

    }
    
    /**
     * Test if the setLines accepts a callable 
     */
    public function testIfInvoiceSetLinesAcceptsCallable():void {

        $called = false;

        $this->invoice->setLines(function($invoice) use (&$called) {
            $called = true;
        });

        $this->assertTrue($called);
        $this->assertTrue($this->invoice->lines instanceof EbInterfaceInvoiceLines);

    }

    /**
     * Test if a setLines allows add a line from wihtin the callable
     */
    public function testIfInvoiceSetLinesWithCallableAllowsToAddALine():void {

        $this->invoice->setLines(function($invoice, $lines) use (&$called) {
            
            $lines->add(null, function($line){

                $line->setQuantity("STK", 100);

            });

        });

        $this->assertEquals($this->invoice->lines->count(), 1);

    }

    /**
     * Test if the setLines accepts a class
     */
    public function testIfInvoiceSetLinesAcceptsAClass():void {

        $lines = new EbInterfaceInvoiceLines();

        $this->invoice->setLines($lines);

        $this->assertNotNull($this->invoice->lines);
        $this->assertTrue($this->invoice->lines instanceof EbInterfaceInvoiceLines);

    }

    /**
     * Test if the total gross amount sum will be set
     */
    public function testIfInvoiceUpdateTotalWillUpdateTheAmountCorrectly():void {

        // Prepare
        $this->invoice->setLines(function($invoice, $lines) use (&$called) {
            
            $lines->add(null, function($line){

                $line->setQuantity("STK", 100);
                $line->setTax(new EbInterfaceTax("S", 20, $line->getLineAmount()));

            });

        });

        $this->invoice->updateTotal();

        $this->assertEquals(120, $this->invoice->totalGrossAmount);

    }

    /**
     * Test if the total gross amount sum will be set even multiple taxes are used
     */
    public function testIfInvoiceUpdateTotalWillUpdateTheAmountCorrectlyEvenIfMultipleTaxesAreAdded():void {

        // Prepare
        $this->invoice->setLines(function($invoice, $lines) use (&$called) {
            
            $lines->add(null, function($line){

                $line->setQuantity("STK", 1000);
                $line->setTax(new EbInterfaceTax("S", 20, $line->getLineAmount()));

            });

            $lines->add(null, function($line){

                $line->setQuantity("STK", 10);
                $line->setTax(new EbInterfaceTax("S", 10, $line->getLineAmount()));

            });

        });

        $this->invoice->updateTotal();

        $this->assertEquals(1211, $this->invoice->totalGrossAmount);

    }

    /**
     * Test if the prepaid amount can be set
     */
    public function testIfInvoiceSetPrepaidWillUpdateTheValueCorrectly(): void {

        $this->invoice->setPrePaidAmount(1000);

        $this->assertNotNull($this->invoice->totalPrepaid);
        $this->assertEquals(1000, $this->invoice->totalPrepaid);

    }
    
    /**
     * Test if the prepaid amount has an effect on the total payable amount
     */
    public function testIfInvoicePrePaidWillHaveAnEffectOnThePayableAmount(): void {

        $this->invoice->setLines(function($invoice, $lines) use (&$called) {
            
            $lines->add(null, function($line){

                $line->setQuantity("STK", 100)
                     ->setUnitPrice(1)
                     ->setTax(new EbInterfaceTax("S", 0, $line->getLineAmount()));

            })->add(null, function($line){

                $line->setQuantity("STK", 10)
                     ->setUnitPrice(1)
                     ->setTax(new EbInterfaceTax("S", 0, $line->getLineAmount()));

            });

        })->setPrePaidAmount(10)->updateTotal()->updatePayableAmount();

        $this->assertNotNull($this->invoice->totalPayableAmount);
        $this->assertEquals(100, $this->invoice->totalPayableAmount);

    }

    /**
     * Test if the setPaymentMethod accepts also a callable
     */
    public function testIfPaymentMethodAcceptsCallable():void {

        $callable = false;

        $this->invoice->setPaymentMethod(function($paymentMethod) use (&$callable){
            $callable = true;
        });

        $this->assertTrue($callable);
        $this->assertNotNull($this->invoice->paymentMethod);

    }

}   