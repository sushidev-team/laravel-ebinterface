<?php 

namespace Ambersive\Ebinterface\Models;

class EbInterfaceInvoiceLines  {

    public String $header = "";
    public String $footer = "";
    public array $lines = [];
        
    /**
     * Add a line to the invoice lines
     *
     * @param  mixed $line
     * @return void
     */
    public function add(EbInterfaceInvoiceLine $line) {
        $this->lines[] = $line;
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

}