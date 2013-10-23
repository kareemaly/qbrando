<?php namespace Kareem3d\Eloquent;

use Illuminate\Support\ServiceProvider;
use Kareem3d\Eloquent\Extensions\Acceptable\Acceptable;
use Kareem3d\Eloquent\Extensions\Ordered\Ordered;
use Kareem3d\Eloquent\Extensions\Polymorphic\Polymorphic;
use Kareem3d\Eloquent\Extensions\Seen\Seen;

class EloquentServiceProvider extends ServiceProvider {

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
		$this->package('kareem3d/eloquent');

    }

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        Model::registerExtension('Acceptable', Acceptable::getClass());

        Model::registerExtension('Polymorphic', Polymorphic::getClass());

        Model::registerExtension('Ordered', Ordered::getClass());
    }

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}