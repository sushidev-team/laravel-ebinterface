<?php 

namespace Ambersive\Ebinterface\Models;

use Carbon\Carbon;
use Countries;
use Illuminate\Validation\ValidationException;

use Spatie\ArrayToXml\ArrayToXml;
use Ambersive\Ebinterface\Classes\EbInterfaceXml;

use Ambersive\Ebinterface\Enums\UnitTypes;

use Ambersive\Ebinterface\Models\EbInterfaceBase;

class EbInterfaceInvoiceLine extends EbInterfaceBase {

    public String $description = "";

    public float  $quantity = 0.0;
    public String $quantityType = "";
    public String $articleNr = "";

    public float $unitPrice = 1.0;


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

}