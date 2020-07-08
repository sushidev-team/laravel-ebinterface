<?php 

namespace Ambersive\Ebinterface\Classes;

use Ambersive\Ebinterface\Classes\EbInterfaceInvoice;


class EbInterfaceInvoiceHandler {

    public array $invoices = [];

    public function __construct() {

    }
    
    /**
     * Create new Invoice instance
     *
     * @return EbInterfaceInvoice
     */
    public function create(String $id = null):EbInterfaceInvoice {
        
        $invoice = new EbInterfaceInvoice();    

        if ($id !== null){
            $this->invoices[$id] = $invoice;
        }

        return $invoice;
    }

}