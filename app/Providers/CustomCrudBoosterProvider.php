<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CustomCrudBoosterProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        // $loader->alias('Vendor\VendorName\Class', 'App\Vendor\MyCustomClass');
    }
}
