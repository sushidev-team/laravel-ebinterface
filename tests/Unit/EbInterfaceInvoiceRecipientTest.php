<?php

namespace AMBERSIVE\Ebinterface\Tests\Unit;

use Carbon\Carbon;

use Ambersive\Ebinterface\Models\EbInterfaceAddress;
use Ambersive\Ebinterface\Models\EbInterfaceContact;
use Ambersive\Ebinterface\Models\EbInterfaceCompanyLegal;
use Ambersive\Ebinterface\Models\EbInterfaceInvoiceRecipient;
use Ambersive\Ebinterface\Models\EbInterfaceOrderReference;

use AMBERSIVE\Tests\TestCase;

class EbInterfaceInvoiceRecipientTest extends TestCase
{
    public EbINterfaceAddress $address;
    public EbInterfaceContact $contact;
    public EbInterfaceCompanyLegal $legal;
    public EbInterfaceOrderReference $reference;

    protected function setUp(): void
    {
        parent::setUp();
        $this->address = new EbInterfaceAddress("Manuel Pirker-Ihl", "Geylinggasse 15", "Vienna", "1130", "AT", "office@ambersive.com");
        $this->contact = new EbInterfaceContact("Mr", "Manuel Pirker-Ihl");
        $this->legal = new EbInterfaceCompanyLegal();
        $this->reference = new EbInterfaceOrderReference("XXX", now(), "test");
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * Test if the object will be created
     */
    public function testIfInvoiceRecipientCanBeCreatedWithoutExceptions():void {

        $recipient = new EbInterfaceInvoiceRecipient(
            $this->legal,
            $this->address,
            $this->reference,
            $this->contact
        );

        $this->assertNotNull($recipient);
        $this->assertNotNull($recipient->companyLegal);
        $this->assertNotNull($recipient->address);
        $this->assertNotNull($recipient->contact);

    }

    /**
     * Test if contact of the recipipient can be null
     */
    public function testIfInvoiceRecipientContactIsNull():void {

        $recipient = new EbInterfaceInvoiceRecipient(
            $this->legal,
            $this->address,
            $this->reference
        );

        $this->assertNotNull($recipient);
        $this->assertNotNull($recipient->companyLegal);
        $this->assertNotNull($recipient->address);
        $this->assertNull($recipient->contact);

    }

    /**
     * Test if to few arguemnts for the invoice recipient will throw an argument count exeception.
     */
    public function testIfInvoiceRecipientAddressCannotBeNullAndThrowAndException():void {

        $this->expectException(\ArgumentCountError::class);

        $recipient = new EbInterfaceInvoiceRecipient(
            $this->legal
        );

    }
    /**
     * Test if to few arguemnts for the invoice recipient will throw an argument count exeception.
     */
    public function testIfInvoiceRecipientAddressWillThrowInInvalidExeceptionIfEmailIsMissing():void {

        $this->expectException(\Illuminate\Validation\ValidationException::class);

        $recipient = new EbInterfaceInvoiceRecipient(
            $this->legal,
            new EbInterfaceAddress("Manuel Pirker-Ihl", "Geylinggasse 15", "Vienna", "1130", "AT"),
            $this->reference,
        );

    }

    /**
     * Test if the InvoiceRecipient can create a valid xml output
     */
    public function testIfInvoiceRecipientToXmlReturnsTheCorrectXmlOutput():void {

        $recipient = new EbInterfaceInvoiceRecipient(
            $this->legal,
            $this->address,
            $this->reference,
            $this->contact
        );

        $xml = $recipient->toXml();

        $this->assertNotNull($xml);

        $this->assertNotFalse(strpos($xml, '<Email>'));
        $this->assertNotFalse(strpos($xml, '<VATIdentificationNumber>ATU00000000</VATIdentificationNumber>'));
        $this->assertNotFalse(strpos($xml, '<Address><Name>Manuel Pirker-Ihl</Name><Street>Geylinggasse 15</Street><Town>Vienna</Town><ZIP>1130</ZIP><Country CountryCode=\'AT\'>AT</Country><Email>office@ambersive.com</Email></Address>'));
        $this->assertNotFalse(strpos($xml, '<Contact><Salutation>Mr</Salutation><Name>Manuel Pirker-Ihl</Name></Contact>'));
        $this->assertFalse(strpos($xml, '<Address><Address>'));

    }

}