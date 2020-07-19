<?php 

namespace Ambersive\Ebinterface\Models;

class EbInterfaceInvoiceLines  {

    public String $header = "";
    public String $footer = "";

    public String $headerItemList = "";
    public String $footerItemList = "";

    public array $lines = [];
    
    /**
     * Set the header
     *
     * @param  mixed $text
     * @return EbInterfaceInvoiceLines
     */
    public function setHeader(String $text): EbInterfaceInvoiceLines{
        $this->header = $text;
        return $this;
    }
    
    /**
     * Set the footer
     *
     * @param  mixed $text
     * @return EbInterfaceInvoiceLines
     */
    public function setFooter(String $text): EbInterfaceInvoiceLines{
        $this->footer = $text;
        return $this;
    }
    
    /**
     * Set the header in the item list
     *
     * @param  mixed $text
     * @return EbInterfaceInvoiceLines
     */
    public function setHeaderItemList(String $text): EbInterfaceInvoiceLines{
        $this->headerItemList = $text;
        return $this;
    }
    
    /**
     * Set the footer in the item list
     *
     * @param  mixed $text
     * @return EbInterfaceInvoiceLines
     */
    public function setFooterItemList(String $text): EbInterfaceInvoiceLines{
        $this->footerItemList = $text;
        return $this;
    }
        
    /**
     * Add a line to the invoice lines
     *
     * @param  mixed $line
     * @return void
     */
    public function add(?EbInterfaceInvoiceLine $line = null, ?Callable $callable = null) {
        
        if ($line === null) {
            $line = new EbInterfaceInvoiceLine();
        }

        $this->lines[] = $line;

        if (is_callable($callable)) {
            $callable($line, sizeOf($this->lines) - 1);
        }

        return $this;
    }
    
    /**
     * Remove item from the lists
     *
     * @param  mixed $index
     * @param  mixed $amount
     * @return void
     */
    public function remove(int $index = 0, int $amount = 1){
        \array_splice($this->lines, $index, $amount);
        return $this;
    }
    
    /**
     * Returns the amount of elements in the list of lines
     *
     * @return int
     */
    public function count(): int {
        return collect($this->lines)->count();
    }


    /**
     * Transform the lines to a valid xml block
     */
    public function toXml(?String $container = ""): String {

        $lines = collect($this->lines)->map(function($line) use ($container){
            return $line->toXml($container);
        });

        $linesXml = [];

        $this->header !== "" ? $linesXml[] = "<HeaderDescription>$this->header</HeaderDescription>" : null;

        // item list starts here
        $linesXml[] = "<ItemList>";

        $this->headerItemList !== "" ? $linesXml[] = "<HeaderDescription>$this->headerItemList</HeaderDescription>" : null;
        $linesXml[] = implode('', $lines->toArray());
        $this->footerItemList !== "" ? $linesXml[] = "<FooterDescription>$this->footerItemList</FooterDescription>" : null;

        $linesXml[] = "</ItemList>";

        $this->footer !== "" ? $linesXml[] = "<FooterDescription>$this->footer</FooterDescription>" : null;

        return implode("", $linesXml);

    }

}