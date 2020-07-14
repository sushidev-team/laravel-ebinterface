<?php 

namespace Ambersive\Ebinterface\Models;

use Carbon\Carbon;
use Countries;
use Illuminate\Validation\ValidationException;

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



}