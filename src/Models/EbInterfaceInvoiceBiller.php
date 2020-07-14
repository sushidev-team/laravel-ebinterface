<?php 

namespace Ambersive\Ebinterface\Models;

use Carbon\Carbon;

use Ambersive\Ebinterface\Models\EbInterfaceAddress;
use Ambersive\Ebinterface\Models\EbInterfaceContact;

class EbInterfaceInvoiceBiller {

    public ?String $vadId = null;
    public ?EbInterfaceAddress $address = null;
    public ?EbInterfaceContact $contact = null;

    public function __construct(EbInterfaceAddress $address = null, EbInterfaceContact $contact = null, String $vatId = null) {
        


    }

}