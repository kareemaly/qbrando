<?php namespace Asset;

use Exception;

class Asset {

	/**
	 * Contain all js assets
	 *
	 * @var array
	 */
	protected static $jsAssets  = array();
	
	/**
	 * Contain all css assets
	 *
	 * @var array
	 */
	protected static $cssAssets = array();

	/**
	 * Plugins files to be loaded
	 *
	 * @var array
	 */
	protected static $plugins = array();

	/**
	 * Pages assets to be loaded
	 *
	 * @var array
	 */
	protected static $pages = array();

	/**
	 * Determines whether the assets files and plugins has
	 * been loaded.
	 *
	 * @var array
	 */
	protected static $loaded = false;

	/**
	 * Assets path.
	 *
	 * @var Path
	 */
	protected static $assetsUrl = '';

	/**
	 * Plugins folder.
	 *
	 * @var string
	 */
	protected static $pluginsPath = '';

	/**
	 * Pages folder.
	 *
	 * @var string
	 */
	protected static $pagesPath = '';

	/**
	 * Initialize asset class.
	 *
	 * @param  string $assetsUrl
	 * @param  string $pluginsPath
	 * @param  string $pagesPath
	 * @return void
	 */
	public static function init( $assetsUrl , $pluginsPath = '', $pagesPath = '' )
	{
		static::$assetsUrl   = rtrim($assetsUrl, '/');
		static::$pluginsPath = rtrim($pluginsPath, '\\/');
		static::$pagesPath   = rtrim($pagesPath, '\\/');
	}

    /**
     * Return server path to assets directory (public)
     *
     * @throws \Exception
     * @return string
     */
	public static function assetsUrl()
	{
		if(! static::$assetsUrl) throw new Exception("Not initialized.");

		return static::$assetsUrl;
	}

	/**
	 * Return server path to plugins directory
	 *
	 * @return string
	 */
	public static function pluginsPath()
	{
		return static::$pluginsPath;
	}

	/**
	 * Return server path to plugins directory
	 *
	 * @return string
	 */
	public static function pagesPath()
	{
		return static::$pagesPath;
	}

	/**
	 * Add one more page to load its assets
	 *
	 * @param  string $plugin
	 * @return void
	 */
	public static function addPage( $page )
	{
		if(! in_array($page, static::$pages))

			static::$pages[] = $page;
	}

	/**
	 * Add one more plugin
	 *
	 * @param  string $plugin
	 * @return void
	 */
	public static function addPlugin( $plugin )
	{
		if(! in_array($plugin, static::$plugins))
	
			static::$plugins[] = $plugin;
	}

	/**
	 * Add plugins array
	 *
	 * @param  array $plugin
	 * @return void
	 */
	public static function addPlugins( $plugins )
	{
		foreach ($plugins as $plugin)
		{
			static::addPlugin( $plugin );
		}
	}

    /**
     * Set the plugins assets files
     *
     * @param $plugins
     * @return void
     */
	public static function setPlugins( $plugins )
	{
		static::$plugins = $plugins;
	}

    /**
     * Set the assets files
     *
     * @param $pages
     * @return void
     */
	public static function setPages( $pages )
	{
		static::$pages = $pages;
	}

	/** 
	 * Load plugins and pages
	 *
	 * @return void
	 */
	public static function load()
	{
		if(static::$loaded) return;

		static::$loaded = true;

		array_unshift(static::$pages, 'start');
		array_push   (static::$pages, 'end'  );

		static::loadPages();
		static::loadPlugins();
	}

	/**
	 * Load main files that contain the needed assets
	 *
	 * @return void
	 */
	private static function loadPages()
	{
		foreach (static::$pages as $page)
		{
			require static::pagesPath() . '/' . strtolower($page) . '.php';
		}
	}

	/**
	 * Load plugins files that contain the needed assets
	 *
	 * @return void
	 */
	private static function loadPlugins()
	{
		foreach (static::$plugins as $plugin)
		{
			require static::pluginsPath() . '/' . strtolower($plugin) . '.php';
		}
	}

    /**
     * Add new asset either to jsAssets or cssAssets depending on its extension
     *
     * @param string $name
     * @param string $file
     * @param string $depend
     * @param bool $IE9
     * @param string $media
     * @return void
     */
	public static function add( $name, $file , $depend = '', $IE9 = false, $media = 'screen' )
	{
		$pathinfo = pathinfo($file);

		// Check if the given file is already a url (Using asset from another server) then don't modify it
		// else then prepend the assetsUrl.
		$url = static::isUrl($file) ? $file : static::assetsUrl() . '/' . ltrim($file, '/');

		switch ($pathinfo['extension'])
		{
			case 'js':
				static::$jsAssets[] = compact('name', 'url', 'depend', 'IE9');
				static::organize( static::$jsAssets );
				break;
			
			case 'css':
				static::$cssAssets[] = compact('name', 'url', 'depend', 'media');
				static::organize( static::$cssAssets );
				break;
		}
	}

	/**
	 * Return JS array
	 *
	 * @return array
	 */
	public static function getJS()
	{
		return static::$jsAssets;
	}

	/**
	 * Return Css 2D array
	 *
	 * @return array
	 */
	public static function getCSS()
	{
		return static::$cssAssets;
	}

	/**
	 * Return styles as html
	 *
	 * @return string
	 */
	public static function styles()
	{
		if(! static::$loaded) static::load();

		$html = '';
		foreach (static::$cssAssets as $array)
		{
			$html .= '<link rel="stylesheet" href="'.$array['url'].'" media="'.$array['media'].'">'.PHP_EOL;
		}
		return $html;
	}

	/**
	 * Return scripts as html
	 *
	 * @return string
	 */
	public static function scripts()
	{
		if(!static::$loaded) static::load();

		$html = '';
		foreach (static::$jsAssets as $array)
		{
			if(! $array['IE9'])

				$html .= '<script src="'.$array['url'].'"></script>'.PHP_EOL;

			else

				$html .= '<!--[if lt IE 9]>
							<script src="'.$array['url'].'"></script>
						  <![endif]-->'.PHP_EOL;
		}
		return $html;
	}

	/**
	 * Organize array dependencies
	 *
	 * @todo   Multiple dependencies
	 * @param  array $array
	 * @return void
	 */
	public static function organize( &$array )
	{
		for ($i=0; $i < count($array) - 1; $i++)
		{ 
			for ($j=$i + 1; $j < count($array); $j++)
			{ 
				if( $array[ $i ]['depend'] == $array[ $j ]['name'] )
				{
					$tmp       = $array[$i];
					$array[$i] = $array[$j];
					$array[$j] = $tmp;
					break;
				}
			}
		}
	}

	/**
	 * Check if this is a valid url.
	 *
	 * @param  string $url
	 * @return boolean
	 */
	public static function isUrl( $url )
	{
        if(strpos($url, '//') > -1) {

            return true;
        }

		return filter_var($url, FILTER_VALIDATE_URL);;
	}
}