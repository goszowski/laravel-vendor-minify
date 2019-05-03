<?php
namespace Goszowski\VendorMinify;

use Illuminate\Support\ServiceProvider;

class VendorMinifyServiceProvider extends ServiceProvider 
{
	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->mergeConfigFrom(
            __DIR__.'/../../config/cleanup.config.php', 'laravel-vendor-cleanup'
        );

		$this->commands([
            VendorCleanupCommand::class,
            VendorMinifyCommand::class,
        ]);
	}

}