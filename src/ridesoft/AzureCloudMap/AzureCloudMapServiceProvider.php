<?php

namespace ridesoft\AzureCloudMap;

use Illuminate\Support\ServiceProvider;
use ridesoft\AzureCloudMap\AzureIO;
use Config;

class AzureCloudMapServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot() {
        $this->package('ridesoft/AzureCloudMap', 'azurecloudmap');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {
        $this->app['AzureIO'] = $this->app->share(function($app) {      
            return new AzureIO(Config::get('azurecloudmap::config'));
        });
       
    }
    
    public function provides() {
        return ['AzureIO'];
    }

}
