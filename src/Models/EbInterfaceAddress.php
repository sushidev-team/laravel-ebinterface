<?php 

namespace Ambersive\Ebinterface\Models;

use Carbon\Carbon;

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
        $this->countryCode = $countryCode;
    }



}