<?php 

namespace Ambersive\Ebinterface\Models;

use Carbon\Carbon;
use Spatie\ArrayToXml\ArrayToXml;

use Ambersive\Ebinterface\Models\EbInterfaceAddress;
use Ambersive\Ebinterface\Models\EbInterfaceContact;

use Ambersive\Ebinterface\Classes\EbInterfaceXml;

use Ambersive\Ebinterface\Models\EbInterfaceBase;
class EbInterfaceInvoiceDelivery extends EbInterfaceBase{

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
    public function toXml(?String $container = ""):String {

        $data = [
            'Date' => $this->date->format('Y-m-d'),
            'Address' => $this->address->toXml("root"),
            'Contact' => $this->contact !== null ? $this->contact->toArray() : null
        ];

        if ($data['Contact'] === null) {
            unset($data['Contact']);
        }

        $delivery = ArrayToXml::convert($data, $container === "" ? "Delivery" : $container);

        return EbInterfaceXml::clean($delivery, $container);

    }

}