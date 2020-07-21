<?php 

namespace Ambersive\Ebinterface\Models;

use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

use Spatie\ArrayToXml\ArrayToXml;
use Ambersive\Ebinterface\Classes\EbInterfaceXml;
use Ambersive\Ebinterface\Models\EbInterfaceBase;

use Ambersive\Ebinterface\Enums\TaxCodes;

class EbInterfaceDiscount extends EbInterfaceBase {

    public Carbon $date;
    public float $percent = 0;

    public function __construct(Carbon $date, float $percent = 0) {
        $this->date = $date;
        $this->percent = $percent;
    }
    
    /**
     * Export the array to an valid xml for ebInterface
     *
     * @return String
     */
    public function toXml(?String $container = ""):String {

        $result = ArrayToXml::convert($this->toArray(), $container === "" ? "Discount" : $container);
        $result = EbInterfaceXml::clean($result, $container);
        
        return $result;
    }
    
    /**
     * Transform the data into an array
     *
     * @return array
     */
    public function toArray():array {
        return [
            'PaymentDate' => $this->date->format('Y-m-d'),
            'Percentage' => $this->percent
        ];
    }


}