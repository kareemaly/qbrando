<?php

use Illuminate\Support\MessageBag;

try{ View::share('categories', App::make('CategoryAlgorithm')->orderByProducts()->get()); }catch(Exception $e){}
try{ View::share('contactUs', App::make('ContactUs')); }catch(Exception $e){}

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
    $view->special = App::make('ProductAlgorithm')->specials()->available()->first();
});

View::composer('partials.product', function( $view )
{
    $view->showOfferPrice = true;
});