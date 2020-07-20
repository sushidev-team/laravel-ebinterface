<?php 

namespace Ambersive\Ebinterface\Models;

use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

use Spatie\ArrayToXml\ArrayToXml;
use Ambersive\Ebinterface\Classes\EbInterfaceXml;
use Ambersive\Ebinterface\Models\EbInterfaceBase;
use Ambersive\Ebinterface\Models\EbInterfaceInvoiceLines;
use Ambersive\Ebinterface\Models\EbInterfaceTax;

use Ambersive\Ebinterface\Enums\TaxCodes;

use Illuminate\Support\Collection;

class EbInterfaceTaxSummary extends EbInterfaceBase {

    public EbInterfaceInvoiceLines $lines;
    public Collection $taxes;

    public function __construct(EbInterfaceInvoiceLines $lines) {
        $this->lines = $lines;
        $this->calculate();
    }
    
    /**
     * Export the array to an valid xml for ebInterface
     *
     * @return String
     */
    public function toXml(?String $container = ""):String {

        $xml = implode("", $this->taxes->map(function($tax) {
            return "<TaxItem>".$tax->toXml("root") . "<TaxAmount>".$tax->getTax()."</TaxAmount></TaxItem>";
        })->toArray());

        if ($container !== "" && $container !== "root") {
            $xml = "<${container}>${xml}</${container}>";
        }

        $result = EbInterfaceXml::clean($xml, $container);
        return $result;
    }
        
    /**
     * Calculate the taxes and summarize them
     *
     * @return EbInterfaceTaxSummary
     */
    public function calculate():  EbInterfaceTaxSummary{

        $taxes = collect();
        $taxSummary = collect();

        foreach($this->lines->lines as $index => $line) {

            if (isset($line->tax) && $line->tax instanceOf EbInterfaceTax) {
                $taxes->add($line->tax);
            }

        }

        $taxes->each(function($tax) use (&$taxSummary) {

            $taxSearch = $taxSummary->where('type', $tax->type)->where('percent', $tax->percent)->first();

            if ($taxSearch === null) {
                $taxSummary->add(new EbInterfaceTax($tax->type, $tax->percent));
                $taxSearch = $taxSummary->where('type', $tax->type)->where('percent', $tax->percent)->first();
            }

            $taxSearch->addValue($tax->value);

        });

        $this->taxes = $taxSummary;

        return $this;
    }
    
    /**
     * Returns the taxes as array
     *
     * @return array
     */
    public function toArray():array {

        return $this->taxes->map(function($tax) {
            return [
                'TaxableAmount' => $tax->value,
                'TaxPercent' => $tax->percent,
                'TaxAmount' => $tax->getTax(),
                'TaxCategoryCode' => $tax->type
            ];
        })->toArray();
    }

}