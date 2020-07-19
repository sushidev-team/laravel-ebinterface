<?php 

namespace Ambersive\Ebinterface\Models;

class EbInterfaceInvoiceLines  {

    public String $header = "";
    public String $footer = "";
    public array $lines = [];

    public function setHeader(String $header): EbInterfaceInvoiceLines{
        $this->header = $header;
        return $this;
    }

    public function setFooter(String $footer): EbInterfaceInvoiceLines{
        $this->footer = $footer;
        return $this;
    }
        
    /**
     * Add a line to the invoice lines
     *
     * @param  mixed $line
     * @return void
     */
    public function add(EbInterfaceInvoiceLine $line, ?Callable $callable = null) {
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


    public function toXml(?String $container = ""): String {

        $lines = collect($this->lines)->map(function($line) use ($container){
            return $line->toXml($container);
        });

        return "<ItemList><HeaderDescription>$this->header</HeaderDescription>".implode('', $lines->toArray())."<FooterDescription>$this->footer</FooterDescription></ItemList>";

    }

}