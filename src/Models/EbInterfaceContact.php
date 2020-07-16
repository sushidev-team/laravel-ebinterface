<?php 

namespace Ambersive\Ebinterface\Models;

use Carbon\Carbon;
use Countries;
use Illuminate\Validation\ValidationException;

use Spatie\ArrayToXml\ArrayToXml;
use Ambersive\Ebinterface\Classes\EbInterfaceXml;
use Ambersive\Ebinterface\Classes\EbInterfaceCountries;

use Ambersive\Ebinterface\Models\EbInterfaceBase;

class EbInterfaceContact extends EbInterfaceBase {

    public String $salutation = "";
    public String $name = "";

    public function __construct(String $salutation, String $name) {
        $this->salutation = $salutation;
        $this->name = $name;
    }
    
    /**
     * Export the array to an valid xml for ebInterface
     *
     * @return String
     */
    public function toXml(String $container = ""):String {

        $contact = ArrayToXml::convert($this->toArray(), $container === "" ? "Contact" : $container);
        return EbInterfaceXml::clean($contact,);

    }
    
    /**
     * Transform the data into an array
     *
     * @return array
     */
    public function toArray():array {
        return [
            'Salutation' => $this->salutation,
            'Name' => $this->name
        ];
    }


}