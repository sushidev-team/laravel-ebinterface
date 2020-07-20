<?php

namespace AMBERSIVE\Ebinterface\Tests\Unit;

use Config;
use File;

use Ambersive\Ebinterface\Classes\EbInterface;
use Ambersive\Ebinterface\Models\EbInterfacePaymentMethod;
use Ambersive\Ebinterface\Models\EbInterfacePaymentMethodBank;

use AMBERSIVE\Tests\TestCase;

class EbInterfacePaymentMethodTest extends TestCase
{

    protected String $result = "<Comment></Comment><UniversalBankTransaction><BeneficiaryAccount><BIC>TEST</BIC><IBAN>DE75512108001245126199</IBAN><BankAccountOwner>AMBERSIVE KG</BankAccountOwner></BeneficiaryAccount></UniversalBankTransaction>";

    protected function setUp(): void
    {
        parent::setUp();
        Config::set('ebinterface.payment', [
            'iban' => 'DE75512108001245126199',
            'bic' => 'TEST',
            'owner' => 'AMBERSIVE KG'
        ]);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        
    }

    /**
     * Test if there is an argument count error exception if no parameter is provided
     */
    public function testIfInvoicePaymentMethodWilThrowExeceptionForMissingArgument():void {
        $this->expectException(\ArgumentCountError::class);   
        $payment = new EbInterfacePaymentMethod();
    }
    
    /**
     * Test if the given parameter will throw an validation exeception
     */
    public function testIfInvoicePaymentMethodWillThrowExeceptionCauseMethodUnknown():void {
        
        $this->expectException(\Illuminate\Validation\ValidationException::class);
        $payment = new EbInterfacePaymentMethod("TEST");

    }

    /**
     * Test if the set account method accepts an callable
     */
    public function testIfInvoicePaymentMethodSetMethodAcceptsCallable(): void {

        $payment = new EbInterfacePaymentMethod("UniversalBankTransaction");
        $callable = false;

        $payment->setAccount(function($account) use (&$callable){
            $callable = true;
            $this->assertNotNull($account);
        });

        $this->asserttrue($callable);

    }

    /**
     * Test if the set account method also accepts a
     */
    public function testIfInvoicePaymentMethodSetMethodAcceptsClass(): void {

        $payment = new EbInterfacePaymentMethod("UniversalBankTransaction");
        $bank = new EbInterfacePaymentMethodBank();

        $payment->setAccount($bank);

        $this->assertNotNull($payment->account);
        $this->assertTrue($payment->account instanceOf EbInterfacePaymentMethodBank);

    }

    /**
     * Test if toArray method will return a valid array data 
     */
    public function testIfInvoicePaymentMethodToArrayReturnAnValidArray(): void {

        $payment = new EbInterfacePaymentMethod("UniversalBankTransaction");
        $bank = new EbInterfacePaymentMethodBank();

        $payment->setAccount($bank);

        $result = $payment->toArray();

        $this->assertNotNull($result);
        $this->assertNotEmpty($result);
        $this->assertTrue(isset($result['UniversalBankTransaction']['BeneficiaryAccount']));
        $this->assertTrue(isset($result['UniversalBankTransaction']['BeneficiaryAccount']['IBAN']));

    }

    /** 
     * Test if the toXml() method without a container will return the correct xml output
     */
    public function testIfInvoicePaymentMethodToXmlWillReturnValidXml(): void {

        $payment = new EbInterfacePaymentMethod("UniversalBankTransaction");
        $bank = new EbInterfacePaymentMethodBank();

        $payment->setAccount($bank);

        $xml = $payment->toXml("root");

        $this->assertNotNull($xml);
        $this->assertEquals($this->result, $xml);

    }

    /**
     * Test if the toXml() method will return a valid xml output with a PaymentMethod-wrapping element
     */
    public function testIfInvoicePaymentMethodToXmlWithContaineerWillReturnCorrectXmlOutput(): void {
        $payment = new EbInterfacePaymentMethod("UniversalBankTransaction");
        $bank = new EbInterfacePaymentMethodBank();

        $payment->setAccount($bank);

        $xml = $payment->toXml();

        $this->assertNotNull($xml);
        $this->assertEquals("<PaymentMethod>".$this->result."</PaymentMethod>", $xml);

    }

}