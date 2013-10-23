<?php namespace Kareem3d\FreakImages;

use Illuminate\Support\ServiceProvider;
use Kareem3d\Freak;
use Kareem3d\FreakImages\ImagePackage;

class FreakImagesServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

    /**
     * When service provider is booted
     */
    public function boot()
    {
        $this->package('kareem3d/freak-images');
    }

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        Freak\PackageRepository::register(new ImagesPackage);
        Freak\PackageRepository::register(new ImagePackage);
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