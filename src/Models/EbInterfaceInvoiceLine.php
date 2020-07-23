<?php 

namespace Ambersive\Ebinterface\Models;

use Carbon\Carbon;
use Countries;
use Illuminate\Validation\ValidationException;

use Spatie\ArrayToXml\ArrayToXml;
use Ambersive\Ebinterface\Classes\EbInterfaceXml;

use Ambersive\Ebinterface\Enums\UnitTypes;
use Ambersive\Ebinterface\Enums\TaxCodes;

use Ambersive\Ebinterface\Models\EbInterfaceBase;
use Ambersive\Ebinterface\Models\EbInterfaceTax;

class EbInterfaceInvoiceLine extends EbInterfaceBase {

    public String $description = "";

    public float  $quantity = 0.0;
    public String $quantityType = "";
    public String $articleNr = "";

    public float $unitPrice = 1.0;

    public ?EbInterfaceTax $tax = null;

    public ?String $orderID = null;
    public ?int $orderPositionNr = 0;

    public function __construct() {
        
    }
    
    /**
     * Set the description of the invoice line
     *
     * @param  mixed $text
     * @return EbInterfaceInvoiceLine
     */
    public function setDescription(String $text): EbInterfaceInvoiceLine{
        $this->description = $text;
        return $this;
    }
    
    /**
     * Set the quantity based on the the enum "UnitTypes"
     *
     * @param  mixed $type
     * @param  mixed $amount
     * @return EbInterfaceInvoiceLine
     */
    public function setQuantity(String $type, float $amount): EbInterfaceInvoiceLine {
        
        $all = UnitTypes::getAll();

        if (in_array($type, $all) === false) {
            throw ValidationException::withMessages([
                'quantityType' => ['This in no known unit type.'],
            ]);
        }

        $this->quantityType = $type;
        $this->quantity = $amount;
        
        return $this;
    }
    
    /**
     * Set the unit price for the invoice line
     *
     * @param  mixed $price
     * @return EbInterfaceInvoiceLine
     */
    public function setUnitPrice(float $price): EbInterfaceInvoiceLine {
        $this->unitPrice = $price;
        return $this;
    }
    
    /**
     * Set the article nr for the line
     *
     * @param  mixed $articleNr
     * @return EbInterfaceInvoiceLine
     */
    public function setArticleNr(String $articleNr): EbInterfaceInvoiceLine {

        $this->articleNr = $articleNr;
        return $this;

    }
    
    /**
     * Set the tax for this item
     *
     * @param  mixed $tax
     * @return EbInterfaceInvoiceLine
     */
    public function setTax(EbInterfaceTax $tax): EbInterfaceInvoiceLine {
        $this->tax = $tax;
        return $this;
    }
  
    /**
     * Set order reference values
     *
     * @param  mixed $id
     * @param  mixed $orderPositionNr
     * @return EbInterfaceInvoiceLine
     */
    public function setOrderReference(String $id, ?int $orderPositionNr = 0): EbInterfaceInvoiceLine {
        $this->orderID = $id;
        $this->orderPositionNr = $orderPositionNr;
        return $this;
    }
    
    /**
     * Get the NET value for the line
     *
     * @return float
     */
    public function getLineAmount(): float {

        $value = $this->quantity * $this->unitPrice;
        return $value;

    }

    public function toArray(): array {

        $data = [
            'Description' => $this->description,
            'Quantity' => $this->quantity,
            'UnitPrice' => $this->unitPrice
        ];

        if ($this->tax !== null) {

            $data['TaxItem'] = $this->tax->toXml("root");

        }

        $data["LineItemAmount"] = number_format($this->getLineAmount(), 2);

        if ($this->orderID != null) {
            $data['InvoiceRecipientsOrderReference'] = [
                'OrderID' => $this->orderID,
                'OrderPositionNumber' => $this->orderPositionNr
            ];
        }

        return $data;

    }

    public function toXml(?String $container = ""): String {

        $result = ArrayToXml::convert($this->toArray(), $container === "" ? "ListLineItem" : $container);
        $result = EbInterfaceXml::clean($result, $container);

        if ($this->quantityType === "" || $this->quantityType === null) {
            return "";
        }
        $quantityType = $this->quantityType;
        $result = str_replace("<Quantity>", "<Quantity Unit=\"${quantityType}\">", $result);
        return $result;

        
    }

}