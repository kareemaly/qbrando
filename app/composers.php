<?php

View::share('cart', App::make('cart'));

try{ View::share('categories', App::make('Category')->all()); }catch(Exception $e){}


View::composer('partials.lower_header.offers', function( $view )
{
    $view->offers = App::make('Offer')->getActive();
});

View::composer('partials.sidebar.search', function( $view )
{
    $view->colors = App::make('Color')->get();
});

View::composer('partials.sidebar.specials', function( $view )
{
    $view->special = App::make('ProductAlgorithm')->specials()->first();
});