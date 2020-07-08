<?php 

namespace Ambersive\Ebinterface\Classes;

use Carbon\Carbon;

class EbInterfaceInvoice {

    protected String $invoiceNr = "";
    protected Carbon $invoiceDate;

    public function __construct() {
        $this->setInvoiceDate();
    }
    
    /**
     * Set the invoice number
     *
     * @param  mixed $invoiceNr
     * @return EbInterfaceInvoice
     */
    public function setInvoiceNumber(String $invoiceNr): EbInterfaceInvoice {
        $this->invoiceNr = $invoiceNr;
        return $this;
    }
    
    /**
     * Set the invoice date
     *
     * @param  mixed $date
     * @return EbInterfaceInvoice
     */
    public function setInvoiceDate(Carbon $date = null): EbInterfaceInvoice {
        $this->invoiceDate = ($date === null ? Carbon::now() : $date);
        return $this;
    }

    public function setBiller(): EbInterfaceInvoice {

    }

    public function setDelivery(): EbInterfaceInvoice {

    }

    public function setInvoiceRecipient(): EbInterfaceInvoice {

    }

    public function setHeader(): EbInterfaceInvoice {

    }

    public function setFooter(): EbInterfaceInvoice {

    }

    public function setPaymentMethod(): EbInterfaceInvoice {
        
    }

    public function setPaymentConditions(): EbInterfaceInvoice {
        
    }

    public function addLine(): EbInterfaceInvoice {

    }

    public function removeLine(): EbInterfaceInvoice {

    }

    public function addTax(): EbInterfaceInvoice {

    }

    public function removeTax(): EbInterfaceInvoice {

    }

    public function save(): array {

        return [];

    }

}