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
        $loader = $this->app['config']->getLoader();

        // Get environment name
        $env = $this->app['config']->getEnvironment();

        // Add package namespace with path set, override package if app config exists in the main app directory
        if (file_exists(app_path() . '/config/packages/ridesoft/azurecloudmap')) {
            $loader->addNamespace('azurecloudmap', app_path() . '/config/packages/ridesoft/azurecloudmap');
        } else {
            $loader->addNamespace('azurecloudmap', __DIR__ . '/../../config');
        }

        $config = $loader->load($env, 'config', 'azurecloudmap');

        $this->app['config']->set('azurecloudmap::config', $config);
        
        $this->app['AzureIO'] = $this->app->share(function($app) {
            return new AzureIO(Config::get('azurecloudmap::config'));
        });
        
        $this->app['AzureUrl'] = $this->app->share(function($app) {
            return new AzureUrl(Config::get('azurecloudmap::config'));
        });
    }

    public function provides() {
        return ['AzureIO','AzureUrl'];
    }

}
