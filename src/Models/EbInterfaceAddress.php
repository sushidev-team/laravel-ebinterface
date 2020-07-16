<?php 

namespace Ambersive\Ebinterface\Models;

use Carbon\Carbon;
use Countries;
use Illuminate\Validation\ValidationException;

use Spatie\ArrayToXml\ArrayToXml;
use Ambersive\Ebinterface\Classes\EbInterfaceXml;
use Ambersive\Ebinterface\Classes\EbInterfaceCountries;

use Ambersive\Ebinterface\Models\EbInterfaceBase;
class EbInterfaceAddress extends EbInterfaceBase {

    public String $name = "";
    public String $street = "";
    public String $town = "";
    public String $postal = "";
    public String $countryCode = "";
    public ?String $email = null;

    public function __construct(String $name, String $street, String $town, String $postal, String $countryCode = 'AT', ?String $email = null) {
        $this->name = $name;
        $this->street = $street;
        $this->town = $town;
        $this->postal = $postal;

        if ($email !== null) {
            $this->email = $email;
        }

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
     * Add email to the address
     *
     * @param  mixed $email
     * @return EbInterfaceAddress
     */
    public function setEmail(String $email): EbInterfaceAddress {
        $this->email = $email;
        return $this;
    }
    
    /**
     * Export the array to an valid xml for ebInterface
     *
     * @return String
     */
    public function toXml(String $container = ""): String {

        $address = ArrayToXml::convert($this->toArray(), $container === "" ? "Address" : $container);
        $address = str_replace("<Country>","<Country CountryCode='".$this->countryCode."'>", $address);

        return EbInterfaceXml::clean($address);

    }
    
    /**
     * Transform the data into an array
     *
     * @return array
     */
    public function toArray():array {
        $data = [
            'Name' => $this->name,
            'Street' => $this->street,
            'Town' => $this->town,
            'ZIP' => $this->postal,
            'Country' => $this->countryCode
        ];

        if ($this->email !== null) {
            $data['Email'] = $this->email;
        }

        return $data;
    }


}