<?php 

namespace Ambersive\Ebinterface\Models;

use Validator;

use Carbon\Carbon;

use Ambersive\Ebinterface\Models\EbInterfaceInvoiceBiller;
use Ambersive\Ebinterface\Models\EbInterfaceInvoiceDelivery;
use Ambersive\Ebinterface\Models\EbInterfaceInvoiceRecipient;
use Ambersive\Ebinterface\Models\EbInterfaceInvoiceLines;
use Ambersive\Ebinterface\Models\EbInterfaceTaxSummary;
use Ambersive\Ebinterface\Models\EbInterfacePaymentMethod;

class EbInterfaceInvoice {

    public String $invoiceNr = "";
    public Carbon $invoiceDate;
    public ?EbInterfaceInvoiceBiller $biller = null;
    public ?EbInterfaceInvoiceDelivery $delivery = null;
    public ?EbInterfaceInvoiceRecipient $recipient = null;

    public String $header = "";
    public String $footer = "";
    public ?EbInterfaceInvoiceLines $lines = null;
    public ?EbInterfaceTaxSummary $taxSummary = null;
    public ?EbInterfacePaymentMethod $paymentMethod = null;

    public float $totalGrossAmount = 0.0;
    public float $totalPayableAmount = 0.0;
    public float $totalPrepaid = 0.0;

    public ?Carbon $paymentDueDate = null;
    public array $paymentDiscounts = [];
    public String $paymentComment = "";

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
    
    /**
     * Set the header of the invoice
     *
     * @param  mixed $text
     * @return EbInterfaceInvoice
     */
    public function setHeader(String $text): EbInterfaceInvoice {
        $this->header = $text;
        return $this;
    }

        
    /**
     * Set the footer of the invoice
     *
     * @param  mixed $text
     * @return EbInterfaceInvoice
     */
    public function setFooter(String $text): EbInterfaceInvoice {
        $this->footer = $text;
        return $this;
    }
    
    /**
     * Set the amount which was already payed
     *
     * @param  mixed $amount
     * @return EbInterfaceInvoice
     */
    public function setPrePaidAmount(float $amount) : EbInterfaceInvoice {
        $this->totalPrepaid = $amount;
        return $this;
    }
    
    /**
     * Set the payment method
     *
     * @param  mixed $method
     * @param  mixed $comment
     * @return EbInterfaceInvoice
     */
    public function setPaymentMethod($method, String $comment = ""): EbInterfaceInvoice {

        if (is_callable($method)) {
            $paymentMethod = new EbInterfacePaymentMethod("UniversalBankTransaction");
            $paymentMethodCallback = $method($paymentMethod);
            $this->paymentMethod = $paymentMethodCallback === null ? $paymentMethod : $paymentMethodCallback;

        }
        else if ($paymentMethod instanceof EbInterfacePaymentMethod) {
            $this->paymentMethod = $method;
        }

        if ($comment != "") {
            $this->paymentMethod->setComment($comment);
        }

        return $this;
    }
    
    /**
     * Set the payment conditions for this invoice
     *
     * @param  mixed $dueDate
     * @param  mixed $discounts
     * @param  mixed $comment
     * @return EbInterfaceInvoice
     */
    public function setPaymentConditions(Carbon $dueDate = null, array $discounts = [], String $comment = ""): EbInterfaceInvoice {
        
        $validator = Validator::make([
            'dueDate' => $dueDate,
            'discounts' => $discounts,
            'comment' => $comment
        ], [
            'discounts' => 'max:2',
        ]);

        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }

        $this->paymentComment = $comment;
        return $this;
    }
    
    /**
     * Set the lines
     *
     * @param  mixed $value
     * @return EbInterfaceInvoice
     */
    public function setLines($value = null): EbInterfaceInvoice {
        if ($value != null && is_callable($value)) {
            $this->lines = new EbInterfaceInvoiceLines();
            $value($this, $this->lines);            
        }
        else if ($value instanceof EbInterfaceInvoiceLines) {
            $this->lines = $value;
        }
        return $this;
    }
    
    /**
     * Will automatically update the tax information from
     * the given lines
     *
     * @return EbInterfaceInvoice
     */
    public function updateTax(): EbInterfaceInvoice {
        $this->taxSummary = new EbInterfaceTaxSummary($this->lines);
        return $this;
    }
    
    /**
     * Will update the toatl sums
     *
     * @return EbInterfaceInvoice
     */
    public function updateTotal(): EbInterfaceInvoice {

        $totalGrossAmount = 0;
        
        $this->updateTax();

        collect($this->lines->lines)->each(function($line) use (&$totalGrossAmount){
            $totalGrossAmount += $line->getLineAmount();
        });
        
        $this->taxSummary->taxes->each(function($tax) use (&$totalGrossAmount){
            $totalGrossAmount += $tax->getTax();
        }); 

        $this->totalGrossAmount = $totalGrossAmount;
        
        return $this;
    }
    
    /**
     * Update the payable amount based on prepaid and updated total
     *
     * @return EbInterfaceInvoice
     */
    public function updatePayableAmount(): EbInterfaceInvoice {
        $this->totalPayableAmount = $this->totalGrossAmount - $this->totalPrepaid;
        return $this;
    }

    public function save(): array {
        
        $this->updateTotal()
             ->updatePayableAmount();

        return [];

    }

}