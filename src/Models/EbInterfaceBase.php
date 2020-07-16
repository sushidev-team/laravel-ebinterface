<?php

namespace Ambersive\Ebinterface\Models;

use Spatie\ArrayToXml\ArrayToXml;
use Ambersive\Ebinterface\Classes\EbInterfaceXml;

class EbInterfaceBase {
    /**
     * Export the array to an valid xml for ebInterface
     *
     * @return String
     */
    public function toXml(String $container = "root"):String {

        $contact = ArrayToXml::convert($this->toArray(), $container);
        return EbInterfaceXml::clean($contact, $container);

    }
}