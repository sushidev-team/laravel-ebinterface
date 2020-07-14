<?php 

namespace Ambersive\Ebinterface\Models;

use Carbon\Carbon;
use Countries;
use Illuminate\Validation\ValidationException;

use Spatie\ArrayToXml\ArrayToXml;

use Ambersive\Ebinterface\Models\EbInterfaceCountries;

class EbInterfaceAddress {

    public String $name = "";
    public String $street = "";
    public String $town = "";
    public String $postal = "";
    public String $countryCode = "";

    public function __construct(String $name, String $street, String $town, String $postal, String $countryCode = 'AT') {
        $this->name = $name;
        $this->street = $street;
        $this->town = $town;
        $this->postal = $postal;

        // Validate if the country code is valid
 
        $list = EbInterfaceCountries::getList('alpha-2')->toArray();
        
        if (in_array($countryCode, $list) === false) {
            throw ValidationException::withMessages([
                'countryCode' => ['Invalid country code used. Please use a valid iso-3166 country code.'],
            ]);
        }

        $this->countryCode = $countryCode;
        
    }
    
    /**
     * Export the array to an valid xml for ebInterface
     *
     * @return String
     */
    public function toXml():String {

        $address = str_replace("<?xml version=\"1.0\"?>","",ArrayToXml::convert([
            'Name' => $this->name,
            'Street' => $this->street,
            'Town' => $this->town,
            'ZIP' => $this->postal,
            'Country' => $this->countryCode
        ], 'Address'));


        $address = str_replace("<Country>","<Country CountryCode='".$this->countryCode."'>", $address);

        return str_replace("\n","",$address);

    }


}