<?php

namespace AMBERSIVE\Ebinterface\Tests\Unit;

use Config;
use File;

use Ambersive\Ebinterface\Classes\EbInterface;

use Ambersive\Ebinterface\Classes\EbInterfaceInvoiceHandler;
use Ambersive\Ebinterface\Models\EbInterfaceInvoice;
use Ambersive\Ebinterface\Models\EbInterfaceInvoiceBiller;
use Ambersive\Ebinterface\Models\EbInterfaceInvoiceDelivery;
use Ambersive\Ebinterface\Models\EbInterfaceInvoiceRecipient;
use Ambersive\Ebinterface\Models\EbInterfaceCompanyLegal;
use Ambersive\Ebinterface\Models\EbInterfaceInvoiceLines;
use Ambersive\Ebinterface\Models\EbInterfaceDiscount;
use Ambersive\Ebinterface\Models\EbInterfacePaymentMethodBank;
use Ambersive\Ebinterface\Models\EbInterfaceMockResponse;

use Ambersive\Ebinterface\Models\EbInterfaceAddress;
use Ambersive\Ebinterface\Models\EbInterfaceContact;
use Ambersive\Ebinterface\Models\EbInterfaceTax;
use Ambersive\Ebinterface\Models\EbInterfaceOrderReference;

use Carbon\Carbon;

use AMBERSIVE\Tests\TestCase;

class EbInterfaceTest extends TestCase
{

    public EbInterface $interface;

    public EbInterfaceInvoiceHandler $invoiceHandler;
    public EbInterfaceInvoice $invoice;
    public EbInterfaceInvoice $invoiceComplete;

    public $address;
    public $contact;
    public $legal;
    public $reference;
    

    protected function setUp(): void
    {
        parent::setUp();

        Config::set('ebinterface.credentials.username', 'TEST');
        Config::set('ebinterface.credentials.password', 'TEST');
        Config::set('ebinterface.webservice', 'https://txm.portal.at/at.gv.bmf.erb.test/V2');

        $this->interface = new EbInterface();
        $this->invoiceHandler = new EbInterfaceInvoiceHandler();

        $this->invoice = $this->invoiceHandler->create();

        // Test data
        $this->address = new EbInterfaceAddress("Manuel Pirker-Ihl", "Geylinggasse 15", "Vienna", "1130", "AT", "office@ambersive.com");
        $this->contact = new EbInterfaceContact("Mr", "Manuel Pirker-XXX");
        $this->legal = new EbInterfaceCompanyLegal();
        $this->reference = new EbInterfaceOrderReference("U37", now(), "test");

        Config::set('ebinterface.payment', [
            'iban' => 'DE75512108001245126199',
            'bic' => 'GIBAATWWXXX',
            'owner' => 'AMBERSIVE KG'
        ]);

        // Big invoice

        $this->invoiceComplete = $this->invoice
                ->setInvoiceNumber("TEST1")
                ->setDelivery(function($invoice) {
                    return new EbInterfaceInvoiceDelivery(
                        Carbon::now(),
                        $this->address->setEmail("office@ambersive.com"),
                        $this->contact
                    );
                })
                ->setBiller(function($invoice) {
                    return new EbInterfaceInvoiceBiller(
                        $this->address,
                        $this->contact
                    );
                })
                ->setRecipient(function($invoice){
                    return new EbInterfaceInvoiceRecipient(
                        $this->legal,
                        $this->address,
                        $this->reference,
                        $this->contact
                    );
                })
                ->setLines(function($invoice, $lines) use (&$called) {
            
                    $lines->add(null, function($line){
        
                        $line->setQuantity("STK", 100)
                             ->setUnitPrice(1)
                             ->setTax(new EbInterfaceTax("S", 0, $line->getLineAmount()));
        
                    })->add(null, function($line){
        
                        $line->setQuantity("STK", 10)
                             ->setUnitPrice(1)
                             ->setTax(new EbInterfaceTax("S", 0, $line->getLineAmount()));
        
                    });
        
                })
                ->setPaymentMethod(function($paymentMethod){
                    $paymentMethod->setAccount(new EbInterfacePaymentMethodBank());
                })
                ->setPaymentConditions(null, [
                    new EbInterfaceDiscount(now()->addDays(2), 1),
                    new EbInterfaceDiscount(now(), 2),
                ]);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }
    
    /**
     * Test if the mesage
     */
    public function testIfSoapMessageWillContainTheCredentials(): void {

        $msg = $this->interface->createSoapMessage("test", true);

        $this->assertNotFalse(strpos($msg, '<wsse:Username>TEST</wsse:Username>'));
        $this->assertNotFalse(strpos($msg, '<wsse:Password>TEST</wsse:Password>'));

    }

    /**
     * Test if the xml body of the invoice will be 
     */
    public function testIfSoapMessageWillBeCreatedCorrectly(): void {

        $msg = $this->interface->createSoapMessage($this->invoice->toXml(), true);
        $this->assertNotFalse(strpos($msg, base64_encode($this->invoice->toXml())));

    }

    /**
     * Test if the request handler will trigger an http request + returns
     * a successful response (attentin this is a mocked reeponse)
     */
    public function testIfSendInvoiceWillReturnSucessfulResponse(): void {

        $response = new EbInterfaceMockResponse(200, []);

        $result = $this->interface->setClient($this->createApiMock([$response]))->sendInvoice($this->invoice, true);
        $this->assertEquals(200, $result->getStatusCode());

    }

    /**
     * Test if the the request will return statuscode 500
     */
    public function testIfSendInvoiceWillFailDueIncorrectCredentials(): void {
        $this->expectException(\GuzzleHttp\Exception\ServerException::class);
        $result = $this->interface->sendInvoice($this->invoice, true);
    }

}