<?php


Route::get('/', function()
{
    return View::make('angular.index');
});


Route::get('/partials/{file}.html', function($file)
{
    return View::make('partials.' . $file);
});