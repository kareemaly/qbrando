<?php

/**
 * @return Kareem3d\Freak\DBRepositories\User
 */
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Kareem3d\Freak;
use Kareem3d\Membership\NoAccessException;

function getUser()
{
    return Freak::instance()->getUser();
}

Route::filter('low-access', function()
{
    $user = getUser();

    if(! $user->hasLowAccess()) throw new NoAccessException;
});


Route::filter('medium-access', function()
{
    $user = getUser();

    if(! $user->hasMediumAccess()) throw new NoAccessException;
});


Route::filter('high-access', function()
{
    $user = getUser();

    if(! $user->hasHighAccess()) throw new NoAccessException;
});


App::error(function(NoAccessException $exception, $code)
{
    dd('You don\'t have enough access to see this page...');
});


App::after(function()
{
    getUser()->makeOnline();
});