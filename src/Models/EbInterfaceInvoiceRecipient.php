<?php 

namespace Ambersive\Ebinterface\Models;

use Validator;

use Carbon\Carbon;

use Ambersive\EbInterface\Models\EbInterfaceCompanyLegal;
use Ambersive\EbInterface\Models\EbInterfaceAddress;
use Ambersive\EbInterface\Models\EbInterfaceContact;
use Ambersive\EbInterface\Models\EbInterfaceOrderReference;

use Ambersive\Ebinterface\Models\EbInterfaceBase;

use Spatie\ArrayToXml\ArrayToXml;
use Ambersive\Ebinterface\Classes\EbInterfaceXml;

use Illuminate\Validation\ValidationException;

class EbInterfaceInvoiceRecipient extends EbInterfaceBase {

    public EbInterfaceCompanyLegal $companyLegal;
    public EbInterfaceAddress $address;
    public ?EbInterfaceContact $contact;
    public EbInterfaceOrderReference $reference;

    public function __construct(EbInterfaceCompanyLegal $companyLegal, EbInterfaceAddress $address, EbInterfaceOrderReference $reference,  ?EbInterfaceContact $contact = null) {
        $this->companyLegal = $companyLegal;
        $this->address = $address;
        $this->contact = $contact;
        $this->reference = $reference;

        $data = array_merge(
            $this->address->toArray()
        );

        $validator = Validator::make($data, [
            'Email' => 'required|email:rfc,dns'
        ]);

        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }
    }
    
    /**
     * Convert the data into a valid xml
     *
     * @param  mixed $container
     * @return String
     */
    public function toXml(?String $container = ""): String {
        $data = ArrayToXml::convert($this->toArray(), $container === "" ? "InvoiceRecipient" : $container);
        $xml = EbInterfaceXml::clean($data, $container);
        return preg_replace('/<[\/]?Legal\>|\\n/','', $xml);
    }

    /**
     * Transform the data into an array
     *
     * @return array
     */
    public function toArray():array {
        return [
            'Legal' => $this->companyLegal->toXml("root"),
            'OrderReference' => $this->reference->toXml("root"),
            'Address' => $this->address->toXml("root"),
            'Contact' => $this->contact->toXml("root")
        ];
    }

}