<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\URL;
use Kareem3d\Freak;
use Kareem3d\Freak\Environment;

// Convert to controllers namespace
function cn($c){ return 'Kareem3d\\Controllers\\' . $c; }

/**
 * @return Environment
 */
function freakEnvironment(){ return Environment::instance(); }

/**
 * Get freak url.
 *
 * @param string $uri
 * @return string
 */
function freakUrl( $uri ){ return URL::to(Config::get('freak::general.prefix') . '/' . trim($uri, '/')); }

/**
 * @param $uri
 * @return mixed
 */
function freakRedirect( $uri ){ return Redirect::to(freakUrl($uri)); }

/**
 * Check if uri is the current freak url
 *
 * @param $uri
 * @return bool
 */
function freakCurrent( $uri ){

    $prefix = freakPrefix();

    return ($prefix . '/' . $uri) === Request::path();
}

/**
 * @return string
 */
function freakPrefix()
{
    return trim(Config::get('freak::general.prefix'), '/');
}

/**
 * @return string
 */
function freakDomain()
{
    return Config::get('freak::general.domain');
}

/**
 * @return string
 */
function freakUri()
{
    $prefix = freakPrefix();
    $path = Request::path();

    if (substr($path, 0, strlen($prefix)) == $prefix) {
        $path = substr($path, strlen($prefix));
    }

    return trim($path, '/');
}

/**
 * Get route configurations
 *
 * @return array
 */
function freakRouteConfig(){
    $routeConfig['domain'] = Config::get('freak::general.domain');
    $routeConfig['prefix'] = Config::get('freak::general.prefix');

    return $routeConfig;
}