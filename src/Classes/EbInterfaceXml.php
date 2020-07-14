<?php 

namespace Ambersive\Ebinterface\Classes;

class EbInterfaceXml {
    
    /**
     * Clean up th xml for valid export
     *
     * @param  mixed $str
     * @return String
     */
    public static function clean(String $str):String {

        $str = str_replace("<?xml version=\"1.0\"?>","", $str);

        $str = preg_replace('/&lt;/','<', $str);
        $str = preg_replace('/&gt;/','>', $str);

        $str = str_replace("\n", "", $str);

        return $str;

    }

}