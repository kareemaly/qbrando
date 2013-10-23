<?php namespace Kareem3d\Images;

use Illuminate\Support\ServiceProvider;
use Kareem3d\Eloquent\Model;
use Kareem3d\Images\Extensions\Images;
use Kareem3d\Images\Extensions\MainImage;

class ImagesServiceProvider extends ServiceProvider {

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
		$this->package('kareem3d/images');

        include __DIR__ . '/../../bindings.php';
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        Model::registerExtension('Images', Images::getClass());
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