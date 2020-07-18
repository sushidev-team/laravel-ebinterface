<?php 

namespace Ambersive\Ebinterface\Models;

use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

use Spatie\ArrayToXml\ArrayToXml;
use Ambersive\Ebinterface\Classes\EbInterfaceXml;
use Ambersive\Ebinterface\Models\EbInterfaceBase;

use Ambersive\Ebinterface\Enums\TaxCodes;

class EbInterfaceTax extends EbInterfaceBase {

    public String $type = "S";
    public float $percent = 20;
    public float $value = 0;

    public function __construct(?String $type = "S", ?float $percent = 20, $value = 0) {
        $this->type = $type;
        $this->percent = $percent;

        if (is_callable($value)) {
            $this->value = $value($this);
        }
        else {
            $this->value = floatval($value);
        }

        $taxCodes = TaxCodes::TAXRATES()->getValue();

        if (in_array($type, $taxCodes) === false) {
            throw ValidationException::withMessages([
                'type' => ['Unknown tax type.'],
            ]);
        }
    }
    
    /**
     * Set the amount of the value 
     *
     * @param  mixed $attr
     * @return void
     */
    public function setValue($attr): EbInterfaceTax {
        is_callable($attr) ? $this->value = $attr($this) : $this->value = floatval($attr);
        return $this;
    }
    
    /**
     * Returns the tax
     *
     * @return float
     */
    public function getTax(): float {
        return $this->value / 100 * $this->percent;
    }
    
    /**
     * Export the array to an valid xml for ebInterface
     *
     * @return String
     */
    public function toXml(?String $container = ""):String {

        $tax = ArrayToXml::convert($this->toArray(), $container === "" ? "TaxItem" : $container);
        $result = EbInterfaceXml::clean($tax, $container);
        $result = str_replace("<TaxPercent>", "<TaxPercent TaxCategoryCode='".$this->type."'>", $result);

        return $result;
    }
    
    /**
     * Transform the data into an array
     *
     * @return array
     */
    public function toArray():array {
        return [
            'TaxableAmount' => $this->value,
            'TaxPercent' => $this->percent
        ];
    }


}