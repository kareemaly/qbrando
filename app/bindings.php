<?php

App::bind('Kareem3d\Ecommerce\Product', function()
{
    return new Product();
});

App::bind('Kareem3d\Ecommerce\Category', function()
{
    return new Category();
});