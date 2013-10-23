<?php

use Illuminate\Support\Facades\Route;
use Kareem3d\Freak;

Route::group(freakRouteConfig(), function () {

    Route::get('/', function(){ return freakRedirect('home'); });

    Route::group(array('before' => 'low-access'), function ()
    {
        Route::controller('home', cn('HomeController'));
        Route::controller('discussion', cn('DiscussionController'));
        Route::controller('mail', cn('MailController'));
        Route::controller('my-contacts', cn('ContactsController'));
    });

    Route::group(array('before' => 'medium-access'), function ()
    {
    });

    Route::group(array('before' => 'high-access'), function ()
    {
        Route::controller('permissions', cn('PermissionsController'));
    });

    // Call all freak routes
    foreach(Freak::instance()->getRoutes() as $route)
    {
        call_user_func_array(array('Route', array_shift($route)), $route);
    }

    Route::controller('packages', cn('PackagesController'));

});