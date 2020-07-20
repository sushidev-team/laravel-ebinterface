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

    public EbInterface $interface;

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
     * Test if the set account method also accepts a class
     */
    public function testIfInvoicePaymentMethodSetMethodAcceptsClass(): void {

        $payment = new EbInterfacePaymentMethod("UniversalBankTransaction");
        $bank = new EbInterfacePaymentMethodBank();

        $payment->setAccount($bank);

        $this->assertNotNull($payment->account);
        $this->assertTrue($payment->account instanceOf EbInterfacePaymentMethodBank);

    }

}