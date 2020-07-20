<?php

namespace AMBERSIVE\Ebinterface\Tests\Unit;

use Config;
use File;

use Ambersive\Ebinterface\Classes\EbInterface;
use Ambersive\Ebinterface\Models\EbInterfacePaymentMethod;

use AMBERSIVE\Tests\TestCase;

class EbInterfacePaymentMethodTest extends TestCase
{

    public EbInterface $interface;

    protected function setUp(): void
    {
        parent::setUp();
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

}