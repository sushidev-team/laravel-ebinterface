<?php 

namespace Ambersive\Ebinterface\Models;

use Carbon\Carbon;
use Countries;
use Illuminate\Validation\ValidationException;

use Spatie\ArrayToXml\ArrayToXml;
use Ambersive\Ebinterface\Classes\EbInterfaceXml;
use Ambersive\Ebinterface\Classes\EbInterfaceCountries;

use Ambersive\Ebinterface\Models\EbInterfaceBase;

class EbInterfaceInvoiceLine extends EbInterfaceBase {

    public String $description = "";

    public float  $quantity = 0;
    public String $quantityType = "";

    public function __construct() {
        
    }

}