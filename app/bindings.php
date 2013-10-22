<?php

use Kareem3d\Ecommerce\Category;

View::share('cart', App::make('cart'));


View::composer('partials.offers', function( $view )
{
    $view->offers = App::make('Offer')->getActive();
});

View::composer('partials.search_form', function( $view )
{
    $view->categories = App::make(Category::getClass())->get();
    $view->colors = App::make('Color')->get();
});


View::composer('sidebar.categories', function( $view )
{
    $view->categories = App::make(Category::getClass())->get();
});

View::composer('sidebar.colors', function( $view )
{
    $view->colors = App::make(Color::getClass())->get();
});

View::composer('sidebar.specials', function( $view )
{
    $view->special = App::make('ProductAlgorithm')->specials()->first();
});