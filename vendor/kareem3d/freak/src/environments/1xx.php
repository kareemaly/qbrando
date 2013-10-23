<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::group(freakRouteConfig(), function()
{
    // Logout user
    Route::get('/logout', function()
    {
        Auth::logout();

        return freakRedirect('home');
    });


    Route::get('/update/online', function()
    {
        \Kareem3d\Freak\Environment::instance()->authUser()->makeOnline();
    });
});