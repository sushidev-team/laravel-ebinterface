<?php 

namespace Ambersive\Ebinterface\Classes;

use Ambersive\Ebinterface\Models\EbInterfaceInvoice;

use GuzzleHttp\Exception\GuzzleException;
use \GuzzleHttp\Client;

use Ambersive\Ebinterface\Classes\EbInterfaceInvoiceHandler;

class EbInterface {

    public EbInterfaceInvoiceHandler $invoiceCreator;
    public Client $client;

    public function __construct(\GuzzleHttp\Client $client = null) {
        $this->invoiceCreator = new EbInterfaceInvoiceHandler();
        $this->client = $client != null ? $client : new Client();
    }

    /**
     * Define a GuzzleHttpClient (primarly for testing purpose)
     *
     * @param  mixed $client
     * @return void
     */
    public function setClient(\GuzzleHttp\Client $client): EbInterface {
        $this->client = $client;
        return $this;
    }
    
    /**
     * Send invoice to e-rechnung / austrian government
     *
     * @param  mixed $invoice
     * @param  mixed $test
     * @return void
     */
    public function sendInvoice(EbInterfaceInvoice $invoice, bool $test = false) {

        $message = $this->createSoapMessage($invoice->toXml(), $test);

        $result = $this->client->request('POST', config('ebinterface.webservice') , [
            'headers' => [
                'Content-Type' => 'text/xml; charset=UTF8',
            ],
            'body' => $message                         
        ]);

        return $result;

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