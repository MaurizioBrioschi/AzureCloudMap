<?php namespace ridesoft\AzureCloudMap\Facades;

use Illuminate\Support\Facades\Facade;
/**
 * Facade for Laravel 4.2 and ridesoft\AzureCloudMap\AzureIO
 */
class AzureIO extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() {
        return 'AzureIO';
    }
    
    

}
