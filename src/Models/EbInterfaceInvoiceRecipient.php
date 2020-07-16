<?php 

namespace Ambersive\Ebinterface\Models;

use Validator;

use Carbon\Carbon;

use Ambersive\EbInterface\Models\EbInterfaceCompanyLegal;
use Ambersive\EbInterface\Models\EbInterfaceAddress;
use Ambersive\EbInterface\Models\EbInterfaceContact;

use Ambersive\Ebinterface\Models\EbInterfaceBase;

use Spatie\ArrayToXml\ArrayToXml;
use Ambersive\Ebinterface\Classes\EbInterfaceXml;

use Illuminate\Validation\ValidationException;

class EbInterfaceInvoiceRecipient extends EbInterfaceBase {

    public EbInterfaceCompanyLegal $companyLegal;
    public EbInterfaceAddress $address;
    public ?EbInterfaceContact $contact;

    public function __construct(EbInterfaceCompanyLegal $companyLegal, EbInterfaceAddress $address, ?EbInterfaceContact $contact = null) {
        $this->companyLegal = $companyLegal;
        $this->address = $address;
        $this->contact = $contact;

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

    public function toXml(?String $container = null): String {

        $data = ArrayToXml::convert($this->toArray(), 'InvoiceRecipient');
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
            'Address' => $this->address->toXml("root"),
            'Contact' => $this->contact->toXml("root")
        ];
    }

}