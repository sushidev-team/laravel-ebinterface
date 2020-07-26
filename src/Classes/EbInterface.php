<?php 

namespace Ambersive\Ebinterface\Classes;

use SoapClient;
use SoapFault;

use Ambersive\Ebinterface\Classes\EbInterfaceInvoiceHandler;

class EbInterface {

    public EbInterfaceInvoiceHandler $invoiceCreator;

    public function __construct() {
        $this->invoiceCreator = new EbInterfaceInvoiceHandler();
    }

    public function sendInvoice(EbInterfaeInvoice $invoice, bool $test = false) {

        $message = $this->createSoapMessage($invoice->toXml(), $test);



    }
    
    /** 
     * Will create the soap message for the invoice file
     *
     * @param  mixed $msg
     * @param  mixed $test
     * @return String
     */
    public function createSoapMessage(String $msg, bool $test = false): String {

        $username = config('ebinterface.credentials.username');
        $password = config('ebinterface.credentials.password');

        $base64 = base64_encode($msg);
        $isTest = $test === true ? 'true' : 'false';

        $soapMessage = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n
                        <env:Envelope xmlns:env=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:wsse=\"http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd\">
                        <env:Header>
                            <wsse:Security>
                                <wsse:UsernameToken>
                                    <wsse:Username>$username</wsse:Username>
                                    <wsse:Password>$password</wsse:Password>
                                </wsse:UsernameToken>
                            </wsse:Security>
                        </env:Header>
                        <env:Body>
                        <erb:deliverInvoiceInvoiceInput xmlns:erb=\"http://erb.eproc.brz.gv.at/ws/invoicedelivery/201306/\">
                        <erb:Invoice encoding=\"utf-8\">$base64</erb:Invoice>
                        <erb:Settings test=\"$isTest\" language=\"de\"/>
                        </erb:deliverInvoiceInvoiceInput>
                        </env:Body>
                        </env:Envelope>";

        $soapMessage = preg_replace("/\\s{2,} /", " ", $soapMessage);
        $soapMessage = str_replace("\t", "", $soapMessage);
        $soapMessage = str_replace("\n", "", $soapMessage);

        return $soapMessage;

    }

}