<?php 

namespace Ambersive\Ebinterface\Models;

use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

use Spatie\ArrayToXml\ArrayToXml;
use Ambersive\Ebinterface\Classes\EbInterfaceXml;
use Ambersive\Ebinterface\Models\EbInterfaceBase;

use Illuminate\Support\Facades\Validator;

class EbInterfacePaymentMethodBank extends EbInterfaceBase {

    public ?String $bic = "";
    public ?String $iban = "";
    public ?String $owner = "";

    public function __construct(?String $iban = null, ?String $bic = null, ?String $owner = null) {

        $this->iban  = $iban == null ?  config('ebinterface.payment.iban') : $iban;
        $this->bic   = $bic == null ?   config('ebinterface.payment.bic') : $bic;
        $this->owner = $owner == null ? config('ebinterface.payment.owner') : $owner;

        $validator = Validator::make(
            [
               'iban' => $this->iban,
               'bic' => $this->bic,
               'owner' => $this->owner
            ], [
            'owner' => 'required',
            'iban'  => 'iban',
        ]);

        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }
    }
    
    /**
     * Export the array to an valid xml for ebInterface
     *
     * @return String
     */
    public function toXml(?String $container = ""):String {

        $result = ArrayToXml::convert($this->toArray(), $container === "" ? "BeneficiaryAccount" : $container);
        $result = EbInterfaceXml::clean($result, $container);
        return $result;
    }
    
    /**
     * Transform the data into an array
     *
     * @return array
     */
    public function toArray():array {
        return [
            'BIC' => $this->bic,
            'IBAN' => $this->iban,
            'BankAccountOwner' => $this->owner
        ];
    }


}