<?php 

namespace Ambersive\Ebinterface\Models;

use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

use Spatie\ArrayToXml\ArrayToXml;
use Ambersive\Ebinterface\Classes\EbInterfaceXml;
use Ambersive\Ebinterface\Models\EbInterfaceBase;
use Ambersive\Ebinterface\Models\EbInterfacePaymentMethodBank;

class EbInterfacePaymentMethod extends EbInterfaceBase {

    protected array $allowedTypes = [
        "UniversalBankTransaction"
    ];

    public String $type;
    public String $comment = "";

    public EbInterfacePaymentMethodBank $account;

    public function __construct(String $type) {
        if (in_array($type, $this->allowedTypes) === false) {
            throw ValidationException::withMessages([
                'type' => ['Unknown payment method type.'],
            ]);
        }
        $this->type = $type;
    }
    
    /**
     * Set the payment method comment
     *
     * @param  mixed $comment
     * @return EbInterfacePaymentMethod
     */
    public function setComment(String $comment):EbInterfacePaymentMethod {
        $this->comment = $comment;
        return $this;
    }
    
    /**
     * Set the account by passing a PaymentMethod of or by a callable
     *
     * @param  mixed $account
     * @return EbInterfacePaymentMethod
     */
    public function setAccount($account):EbInterfacePaymentMethod {

        if ($this->type === "UniversalBankTransaction" && $account instanceof EbInterfacePaymentMethodBank) {
            $this->account = $account;
        }
        else if ($this->type === "UniversalBankTransaction" && is_callable($account)) {
            $accountDefault = new EbInterfacePaymentMethodBank();
            $result = $account($accountDefault);
            $this->account = $result !== null ? $result : $accountDefault;
        }

        return $this;

    }
    
    /**
     * Export the array to an valid xml for ebInterface
     *
     * @return String
     */
    public function toXml(?String $container = ""):String {

        $result = ArrayToXml::convert($this->toArray(), $container === "" ? "PaymentMethod" : $container);
        $result = EbInterfaceXml::clean($result, $container);
        return $result;
    }
    
    /**
     * Transform the data into an array
     *
     * @return array
     */
    public function toArray():array {
        $data = [
            'Comment' => $this->comment,
        ];

        if ($this->type === "UniversalBankTransaction" && isset($this->account) && $this->account !== null){
            $data['UniversalBankTransaction'] = [
                'BeneficiaryAccount' => $this->account->toArray()
            ];
        }

        return $data;
    }


}