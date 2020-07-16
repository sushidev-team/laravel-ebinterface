<?php

namespace AMBERSIVE\Ebinterface\Tests\Unit;

use Carbon\Carbon;

use Ambersive\Ebinterface\Models\EbInterfaceCompanyLegal;

use AMBERSIVE\Tests\TestCase;

class EbInterfaceCompanyLegalTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * Test if Company legal can be generated even no params are passed
     */
    public function testIfInvoiceCompanyLegalShouldNotThrowException():void {

        $company = new EbInterfaceCompanyLegal();

        $this->assertNotNull($company);
        $this->assertEquals("ATU00000000", $company->vatId);

    }

    public function testIfInvoiceCompanyLegalHasXmlFunction():void {

        $company = new EbInterfaceCompanyLegal();
        $xml = $company->toXml();

        $this->assertNotNull($xml);
        $this->assertNotFalse(strpos($xml,$company->vatId));

    }

}