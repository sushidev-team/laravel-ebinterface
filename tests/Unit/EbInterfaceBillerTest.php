<?php

namespace AMBERSIVE\Ebinterface\Tests\Unit;

use Config;

use Carbon\Carbon;

use Ambersive\Ebinterface\Models\EbInterfaceAddress;
use Ambersive\Ebinterface\Models\EbInterfaceContact;
use Ambersive\Ebinterface\Models\EbInterfaceInvoiceBiller;

use AMBERSIVE\Tests\TestCase;

class EbInterfaceBillerTest extends TestCase
{

    public EbINterfaceAddress $address;
    public EbInterfaceContact $contact;

    protected function setUp(): void
    {
        parent::setUp();
        $this->address = new EbInterfaceAddress("Manuel Pirker-Ihl", "Geylinggasse 15", "Vienna", "1130", "AT", "office@ambersive.com");
        $this->contact = new EbInterfaceContact("Mr", "Manuel Pirker-Ihl");

        Config::set('ebinterface.biller', [
            'vatId'             => 'ATU123456789',
            'name'              => 'Manuel Ihl',
            'street'            => 'Geylinggasse 15',
            'postal'            => '1130',
            'town'              => 'Vienna',
            'countryCode'       => 'AT',
            'email'             => 'office@picapipe.com',
            'salutation'        => 'Mr',
            'salutation_name'   => 'Ihl'
        ]);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * Test if the email attribute is present
     */
    public function testIfEbInterfaceBillerHasAnEmailAttribute():void {

        $this->assertNotNull($this->address);
        $this->assertNotNull($this->address->email);

    }

    /**
     * Test if the create XML works
     */
    public function testIfEbInterfaceBillerCanCreateXml():void {
        $biller = new EbInterfaceInvoiceBiller();
        $xml = $biller->toXml("root");

        $this->assertNotNull($biller);
        $this->assertNotNull($xml);
        $this->assertFalse(strpos($xml, "&lt;"));
        $this->assertNotFalse(strpos($xml, "<Salutation>Mr</Salutation>"));
    }

    /**
     * Test if the validation for the Invoice biller part works
     */
    public function testIfEbInterfaceBillerValidationWorks():void {

        $this->expectException(\Illuminate\Validation\ValidationException::class);

        Config::set('ebinterface.biller', [
            'vatId'             => 'ATU123456789',
            'name'              => 'Manuel Ihl',
            'street'            => 'Geylinggasse 15',
            'postal'            => '1130',
            'town'              => 'Vienna',
            'countryCode'       => 'AT',
            'email'             => '',
            'salutation'        => 'Mr',
            'salutation_name'   => 'Ihl'
        ]);

        $biller = new EbInterfaceInvoiceBiller();

    }

}