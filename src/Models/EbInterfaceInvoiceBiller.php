<?php 

namespace Ambersive\Ebinterface\Models;

use Validator;

use Carbon\Carbon;

use Spatie\ArrayToXml\ArrayToXml;

use Ambersive\Ebinterface\Classes\EbInterfaceXml;
use Ambersive\Ebinterface\Models\EbInterfaceAddress;
use Ambersive\Ebinterface\Models\EbInterfaceContact;
use Ambersive\Ebinterface\Models\EbInterfaceBase;

use Illuminate\Validation\ValidationException;
class EbInterfaceInvoiceBiller extends EbInterfaceBase {

    public ?String $vatId = null;
    public ?String $billerId = null;
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

        $this->vatId = $vatId != null ? $vatId : config('ebinterface.biller.vatId', 'ATU00000000');
        $this->billerId = $billerId != null ? $billerId : config('ebinterface.biller.billerId', '0');

        $data = array_merge(
            $this->address->toArray(),
            ['InvoiceRecipientsBillerID' => $this->billerId]
        );

        $validator = Validator::make($data, [
            'Email' => 'required|email:rfc,dns',
            'InvoiceRecipientsBillerID' => 'required'
        ]);

        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }

    }

    /**
     * Transform the XML to a valid xml
     *
     * @return String
     */
    public function toXml(?String $container = ""):String{

        $data = [
            'VATIdentificationNumber' => $this->vatId,
            'Address' => $this->address->toXml("root"),
            'Contact' => $this->contact !== null ? $this->contact->toArray() : null,
            'InvoiceRecipientsBillerID' => $this->billerId
        ];

        if ($data['Contact'] === null) {
            unset($data['Contact']);
        }

        $biller = ArrayToXml::convert($data, 'Biller');

        return EbInterfaceXml::clean($biller, $container);

    }

}