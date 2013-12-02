<?php

use Illuminate\Support\MessageBag;

try{ View::share('categories', App::make('Category')->getNotEmpty()); }catch(Exception $e){}

View::share('success', new MessageBag((array) Session::get('success', array())));


View::composer('partials.lower_header.offers', function( $view )
{
    $view->offers = App::make('Offer')->getActive();
});

View::composer('partials.sidebar.search', function( $view )
{
    $view->colors = App::make('Color')->getNotEmpty();
});

View::composer('partials.sidebar.specials', function( $view )
{
    $view->special = App::make('ProductAlgorithm')->specials()->first();
});