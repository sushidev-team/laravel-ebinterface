<?php 

namespace Ambersive\Ebinterface\Models;

use Carbon\Carbon;
use Spatie\ArrayToXml\ArrayToXml;

use Ambersive\Ebinterface\Models\EbInterfaceAddress;
use Ambersive\Ebinterface\Models\EbInterfaceContact;

use Ambersive\Ebinterface\Classes\EbInterfaceXml;

class EbInterfaceInvoiceDelivery {

    public Carbon $date;
    public EbInterfaceAddress $address;
    public ?EbInterfaceContact $contact = null;

    public function __construct(Carbon $date, EbInterfaceAddress $address, EbInterfaceContact $contact = null) {
        $this->address = $address;
        $this->date = $date;

        if ($contact !== null){
            $this->contact = $contact;
        }
    }
    
    /**
     * Transform the XML to a valid xml
     *
     * @return String
     */
    public function toXml():String{

        $data = [
            'Date' => $this->date->format('Y-m-d'),
            'Address' => preg_replace('/<[\/]?Address\>|\\n/','', $this->address->toXml()),
            'Contact' => $this->contact !== null ? $this->contact->toArray() : null
        ];

        if ($data['Contact'] === null) {
            unset($data['Contact']);
        }

        $delivery = ArrayToXml::convert($data, 'Delivery');

        return EbInterfaceXml::clean($delivery);

    }

}