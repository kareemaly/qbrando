<?php namespace Kareem3d\Freak;

use Illuminate\Support\ClassLoader;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Kareem3d\Freak;
use Kareem3d\Freak\Core\ClientInterface;
use Kareem3d\Freak\DBRepositories\ControlPanel;

class FreakServiceProvider extends ServiceProvider {

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
        $this->package('kareem3d/freak');

        $this->app->singleton('FreakManager', function()
        {
            return new Manager(array(
                'assets'       => __DIR__.'/../../assets',
                'helpers'      => __DIR__.'/../../helpers.php',
                'environments' => __DIR__.'/../../environments'
            ));
        });
	}

    /**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
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