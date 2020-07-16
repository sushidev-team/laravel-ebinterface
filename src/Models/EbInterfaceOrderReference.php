<?php 

namespace Ambersive\Ebinterface\Models;

use Carbon\Carbon;
use Countries;
use Illuminate\Validation\ValidationException;

use Spatie\ArrayToXml\ArrayToXml;
use Ambersive\Ebinterface\Classes\EbInterfaceXml;
use Ambersive\Ebinterface\Models\EbInterfaceBase;

class EbInterfaceOrderReference extends EbInterfaceBase{

    public String $orderID;
    public Carbon $referenceDate;
    public String $description = "";

    public function __construct(String $orderID, Carbon $date, ?String $description = null) {
        $this->orderID = $orderID;
        $this->referenceDate = $date;
        $this->description = $description != null ? $description : "";
    }
    
    /**
     * Transform the data into an array
     *
     * @return array
     */
    public function toArray():array {
        return [
            'OrderID' => $this->orderID,
            'ReferenceDate' => $this->referenceDate->format("Y-m-d"),
            'Description' => $this->description
        ];
    }


}