<?php 

namespace Ambersive\Ebinterface\Models;

use Carbon\Carbon;
use Spatie\ArrayToXml\ArrayToXml;

use Ambersive\Ebinterface\Models\EbInterfaceAddress;

use Ambersive\Ebinterface\Classes\EbInterfaceXml;

class EbInterfaceInvoiceDelivery {

    public Carbon $date;
    public EbInterfaceAddress $address;

    public function __construct(EbInterfaceAddress $address, Carbon $date) {
        $this->address = $address;
        $this->date = $date;
    }
    
    /**
     * Transform the XML to a valid xml
     *
     * @return String
     */
    public function toXml():String{

        $delivery = ArrayToXml::convert([
            'Date' => $this->date->format('Y-m-d'),
            'Address' => preg_replace('/<[\/]?Address\>|\\n/','', $this->address->toXml())
        ], 'Delivery');

        return EbInterfaceXml::clean($delivery);

    }

}