<?php 

namespace Ambersive\Ebinterface\Classes;

use SoapClient;
use SoapFault;

use Ambersive\Ebinterface\Classes\EbInterfaceInvoiceHandler;

class EbInterface {

    public SoapClient $client;

    public EbInterfaceInvoiceHandler $invoiceCreator;

    public function __construct(String $wsdl = null) {
        $this->client = new SoapClient($wsdl === null ? (config('ebinterface.testMode', false) === false ? config('ebinterface.wsdl.prodction') : config('ebinterface.wsdl.testing')) : $wsdl);
        $this->invoiceCreator = new EbInterfaceInvoiceHandler();
    }

}