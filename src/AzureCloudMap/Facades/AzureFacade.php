<?php namespace ridesoft\AzureCloudMap\Facades;

use Illuminate\Support\Facades\Facade;

class AzureFacade extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() {
        return 'AzureCloudMap';
    }

}
