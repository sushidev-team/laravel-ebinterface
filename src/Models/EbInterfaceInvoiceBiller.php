<?php 

namespace Ambersive\Ebinterface\Models;

use Carbon\Carbon;

use Spatie\ArrayToXml\ArrayToXml;

use Ambersive\Ebinterface\Classes\EbInterfaceXml;
use Ambersive\Ebinterface\Models\EbInterfaceAddress;
use Ambersive\Ebinterface\Models\EbInterfaceContact;

class EbInterfaceInvoiceBiller {

    public ?String $vadId = null;
    public ?String $billderId = null;
    public ?EbInterfaceAddress $address = null;
    public ?EbInterfaceContact $contact = null;

    public function __construct(?EbInterfaceAddress $address = null, ?EbInterfaceContact $contact = null, ?String $vatId = null, ?String $billerId = null) {

        $this->address = $address != null ?  $address : new EbInterfaceAddress(
            config('ebinterface.biller.name'),
            config('ebinterface.biller.street'),
            config('ebinterface.biller.town'),
            config('ebinterface.biller.postal'),
            config('ebinterface.biller.countryCode'),
            config('ebinterface.biller.email', null)
        );

        $this->contact = $contact != null ? $contact : new EbInterfaceContact(
            config('ebinterface.biller.salutation'),
            config('ebinterface.biller.salutation_name'),
        );

    }

    /**
     * Transform the XML to a valid xml
     *
     * @return String
     */
    public function toXml():String{

        $data = [
            'VATIdentificationNumber' => $this->vadId,
            'Address' => preg_replace('/<[\/]?Address\>|\\n/','', $this->address->toXml()),
            'Contact' => $this->contact !== null ? $this->contact->toArray() : null,
            'InvoiceRecipientsBillerID' => $this->billderId
        ];

        if ($data['Contact'] === null) {
            unset($data['Contact']);
        }

        $biller = ArrayToXml::convert($data, 'Biller');

        return EbInterfaceXml::clean($biller);

    }

}