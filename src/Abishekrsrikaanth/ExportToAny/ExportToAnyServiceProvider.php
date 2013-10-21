<?php namespace Abishekrsrikaanth\ExportToAny;

use Illuminate\Support\ServiceProvider;

class ExportToAnyServiceProvider extends ServiceProvider {

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
		$this->package('abishekrsrikaanth/export-to-any');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['export-to-any'] = $this->app->share(function ($app) {
			return new ExportToAny();
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('export-to-any');
	}

}