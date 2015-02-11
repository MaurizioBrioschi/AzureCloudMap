<?php namespace ridesoft\AzureCloudMap;

use Illuminate\Support\ServiceProvider;

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
	public function boot()
	{
		$this->package('ridesoft/AzureCloudMap');
	}
	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		
	}

	
}
