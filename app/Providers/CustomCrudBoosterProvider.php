<?php

namespace App\Providers;

// use Illuminate\Support\ServiceProvider;
use crocodicstudio\crudbooster\controllers\PrivilegesController;
use App\Http\Controllers\PrivilegesController as CustomPrivilegesController;
use crocodicstudio\crudbooster\CRUDBoosterServiceProvider;

class CustomCrudBoosterProvider extends CRUDBoosterServiceProvider
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
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('crocodicstudio\crudbooster\controllers\PrivilegesController', 'App\Vendor\Controllers\PrivilegesController');
        $loader->alias('crocodicstudio\crudbooster\controllers\ModulsController', 'App\Vendor\Controllers\ModulsController');
        $loader->alias('crocodicstudio\crudbooster\helpers\CRUDBooster', 'App\Vendor\Helper\CRUDBooster');
        
    }
}
