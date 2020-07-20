<?php

namespace AMBERSIVE\Ebinterface\Tests\Unit;

use Config;
use File;

use Ambersive\Ebinterface\Classes\EbInterface;
use Ambersive\Ebinterface\Models\EbInterfacePaymentMethodBank;

use AMBERSIVE\Tests\TestCase;

class EbInterfacePaymentMethodBankTest extends TestCase
{

    public EbInterfacePaymentMethodBank $bank;

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
     * Test if an empty constructor of a EbInterfacePaymentMethodBank will make use of the config settings
     */
    public function testIfPaymentMethodBankCreateWillUseTheConfigValuesIfNoParamPassed(): void {

        $bank = new EbInterfacePaymentMethodBank();
        $this->assertNotNull($bank);
        $this->assertEquals($bank->iban, 'DE75512108001245126199');
        $this->assertEquals($bank->bic, 'TEST');
        $this->assertEquals($bank->owner, 'AMBERSIVE KG');

    }

    /**
     * The creation of an EbInterfacePaymentMethodBank with an invalid iban should throw an exception
     */
    public function testIfPaymentMethodBankCreateWillCheckForInvalidIban(): void {

        $this->expectException(\Illuminate\Validation\ValidationException::class);
        $bank = new EbInterfacePaymentMethodBank("INVALIDIBAN");

    }

    /**
     * Test if the toArray method will return a valid array
     */
    public function testIfPaymentMethodBankToArrayReturnsValidResult():void {
         $bank = new EbInterfacePaymentMethodBank();
         $result = $bank->toArray();

         $this->assertNotNull($result);
         $this->assertNotEmpty($result);
         $this->assertTrue(isset($result['IBAN']));
         $this->assertTrue(isset($result['BIC']));
         $this->assertTrue(isset($result['BankAccountOwner']));
    }

    /**
     * Test if the toXml method will return a valid result
     */
    public function testIfPaymentMethodBankToXmlReturnsValidXml(): void {

        $bank = new EbInterfacePaymentMethodBank();
        $xml = $bank->toXml("root");

        $this->assertEquals("<BIC>TEST</BIC><IBAN>DE75512108001245126199</IBAN><BankAccountOwner>AMBERSIVE KG</BankAccountOwner>", $xml);

    }

    /**
     * Test if the toXml method with a passed container param will return a valid result
     */
    public function testIfPaymentMethodBankToXmlWithContainerReturnsValidXml(): void {

        $bank = new EbInterfacePaymentMethodBank();
        $xml = $bank->toXml("BeneficiaryAccount");

        $this->assertEquals("<BeneficiaryAccount><BIC>TEST</BIC><IBAN>DE75512108001245126199</IBAN><BankAccountOwner>AMBERSIVE KG</BankAccountOwner></BeneficiaryAccount>", $xml);

    }

}