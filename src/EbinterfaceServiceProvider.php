<?php

namespace Ambersive\Ebinterface;

use App;
use Str;

use Illuminate\Foundation\AliasLoader;

use Illuminate\Support\ServiceProvider;

class EbinterfaceServiceProvider extends ServiceProvider
{

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Configs
        $this->publishes([
            __DIR__.'/Configs/ebinterface.php'         => config_path('ebinterface.php'),
        ],'ebinterface');

        $this->mergeConfigFrom(
            __DIR__.'/Configs/ebinterface.php', 'ebinterface.php'
        );

    }


}
