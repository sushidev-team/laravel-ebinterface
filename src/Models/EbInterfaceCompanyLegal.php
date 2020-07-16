<?php 

namespace Ambersive\Ebinterface\Models;

use Carbon\Carbon;
use Countries;
use Illuminate\Validation\ValidationException;

use Spatie\ArrayToXml\ArrayToXml;
use Ambersive\Ebinterface\Classes\EbInterfaceXml;
use Ambersive\Ebinterface\Classes\EbInterfaceCountries;

use Ambersive\Ebinterface\Models\EbInterfaceBase;

class EbInterfaceCompanyLegal extends EbInterfaceBase {

    public String $FS;
    public String $FN;
    public String $FBG;
    public String $vatId;

    public function __construct(?String $headquarterCity = null, ?String $commerialRegisterNr = null, ?String $commercialCourt = null, ?String $vatId = null) {
        $this->FS    = $headquarterCity !== null ? $headquarterCity : '';
        $this->FN    = $commerialRegisterNr !== null ? $commerialRegisterNr : '';
        $this->FBG   = $commercialCourt !== null ? $commercialCourt : '';
        $this->vatId = $vatId !== null ? $vatId : 'ATU00000000';
    }
    
    /**
     * Export the array to an valid xml for ebInterface
     *
     * @return String
     */
    public function toXml(?String $container = ""):String {

       $lines = [];

       $this->vatId !== '' ? $lines[]  = "<VATIdentificationNumber>$this->vatId</VATIdentificationNumber>" : null;
       $this->FS !== '' ? $lines[]     = "<FurtherIdentification IdentificationType='FS'>$this->FS</FurtherIdentification>" : null;
       $this->FN !== '' ? $lines[]     = "<FurtherIdentification IdentificationType='FN'>$this->FN</FurtherIdentification>" : null;
       $this->FBG !== '' ? $lines[]    = "<FurtherIdentification IdentificationType='FBG'>$this->FBG</FurtherIdentification>" : null;

       return implode('', $lines);

    }

}