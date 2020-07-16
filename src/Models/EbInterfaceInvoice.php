<?php 

namespace Ambersive\Ebinterface\Models;

use Carbon\Carbon;

use Ambersive\Ebinterface\Models\EbInterfaceInvoiceBiller;
use Ambersive\Ebinterface\Models\EbInterfaceInvoiceDelivery;
use Ambersive\Ebinterface\Models\EbInterfaceInvoiceRecipient;

class EbInterfaceInvoice {

    public String $invoiceNr = "";
    public Carbon $invoiceDate;
    public ?EbInterfaceInvoiceBiller $biller = null;
    public ?EbInterfaceInvoiceDelivery $delivery = null;
    public ?EbInterfaceInvoiceRecipient $recipient = null;

    public String $header = "";
    public String $footer = "";

    public function __construct() {
        $this->setInvoiceDate();
    }
        
    /**
     * Returns the invoice data as array
     *
     * @return array
     */
    public function toArray():array {
       return json_decode(json_encode($this),true);
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
    
    /**
     * Set the billing block
     * Parameter can be a callable or an instance of EbInterfaceInvoiceBiller
     *
     * @param  mixed $biller
     * @return EbInterfaceInvoice
     */
    public function setBiller($biller): EbInterfaceInvoice {

        if (is_callable($biller)) {
            $this->biller = $biller($this);
            return $this;
        }

        $this->biller = $biller;
        return $this;
    }
    
    /**
     * Set the delivery address block
     * Parameter can be a callable or an instance of EbInterfaceInvoiceDelivery
     *
     * @param  mixed $delivery
     * @return EbInterfaceInvoice
     */
    public function setDelivery($delivery): EbInterfaceInvoice {

        if (is_callable($delivery)) {
            $this->delivery = $delivery($this);
            return $this;
        }

        $this->delivery = $delivery;
        return $this;
    }
    
    /**
     * Set the invoice recipient bloock
     * Parameter can be a callable or an instance of EbInterfaceInvoiceRecipient
     *
     * @param  mixed $recipient
     * @return EbInterfaceInvoice
     */
    public function setRecipient($recipient): EbInterfaceInvoice {

        if (is_callable($recipient)) {
            $this->recipient = $recipient($this);
            return $this;
        }

        $this->recipient = $recipient;
        return $this;
    }

    public function setHeader(String $text): EbInterfaceInvoice {
        $this->header = $text;
        return $this;
    }

    public function setFooter(String $text): EbInterfaceInvoice {
        $this->footer = $text;
        return $this;
    }

    public function setPaymentMethod(): EbInterfaceInvoice {
        return $this;
    }

    public function setPaymentConditions(): EbInterfaceInvoice {
        return $this;
    }

    public function addLine(): EbInterfaceInvoice {
        return $this;
    }

    public function removeLine(): EbInterfaceInvoice {
        return $this;
    }

    public function addTax(): EbInterfaceInvoice {
        return $this;
    }

    public function removeTax(): EbInterfaceInvoice {
        return $this;
    }

    public function save(): array {

        return [];

    }

}