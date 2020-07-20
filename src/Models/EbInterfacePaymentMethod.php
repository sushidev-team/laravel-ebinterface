<?php 

namespace Ambersive\Ebinterface\Models;

use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

use Spatie\ArrayToXml\ArrayToXml;
use Ambersive\Ebinterface\Classes\EbInterfaceXml;
use Ambersive\Ebinterface\Models\EbInterfaceBase;

class EbInterfacePaymentMethod extends EbInterfaceBase {

    protected array $allowedTypes = [
        "UniversalBankTransaction"
    ];

    public String $type;

    public function __construct(String $type) {
        if (in_array($type, $this->allowedTypes) === false) {
            throw ValidationException::withMessages([
                'type' => ['Unknown payment method type.'],
            ]);
        }
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