<?php 

namespace Ambersive\Ebinterface\Models;

use Carbon\Carbon;
use File;

class EbInterfaceCountries {

    
    /**
     * Returns a list of ISO 3166 country codes
     *
     * @param  mixed $code
     * @return void
     */
    public static function getList(String $code = 'alpha-2'): \Illuminate\Support\Collection {

        if (in_array($code, ['alpha-2', 'alpha-3']) === false){
            return collect([]);
        }

        return collect(json_decode(File::get(__DIR__."/../Data/iso-3166.json"), true))->pluck($code);

    }


}