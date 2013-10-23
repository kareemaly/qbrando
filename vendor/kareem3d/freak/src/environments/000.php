<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

Route::group(freakRouteConfig(), function()
{
    Route::controller('login'   , cn('LoginController'));

    Route::controller('register', cn('RegisterController'));
});


/**
 * Handle not found exception
 */
App::error(function(\Symfony\Component\HttpKernel\Exception\HttpException $exception, $code)
{
    return freakRedirect('login');
});



View::composer('freak::login.index', function($view)
{
    Asset::addPage( 'login' );
});