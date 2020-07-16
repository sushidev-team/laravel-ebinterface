<?php 

namespace Ambersive\Ebinterface\Models;

use Carbon\Carbon;

use Ambersive\EbInterface\Models\EbInterfaceCompanyLegal;
use Ambersive\EbInterface\Models\EbInterfaceAddress;
use Ambersive\EbInterface\Models\EbInterfaceContact;

class EbInterfaceInvoiceRecipient {

    public EbInterfaceCompanyLegal $companyLegal;
    public EbInterfaceAddress $address;
    public EbInterfaceContact $contact;

    public function __construct(EbInterfaceCompanyLegal $companyLegal, EbInterfaceAddress $address, EbInterfaceContact $contact) {
        $this->companyLegal = $companyLegal;
        $this->address = $address;
        $this->contact = $contact;
    }

}