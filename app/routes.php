<?php

// Home controller route
use Kareem3d\Images\Image;
use Kareem3d\Images\Version;

use Intervention\Image\Image as II;

// Home
Route::get('/', array('as' => 'home', 'uses' => 'HomeController@index'));



// Product
$routes[] = Route::get('/{category}/{product}-{id}.html', array('as' => 'product', 'uses' => 'ProductController@show'));

// Category
$routes[] = Route::get('/{category}-{id}.html', array('as' => 'category', 'uses' => 'CategoryController@show'));




// Search sunglasses
Route::get('/search-sunglasses.html', array('as' => 'search-products', 'uses' => 'SearchController@products'));

// Search the whole website
Route::get('/search.html', array('as' => 'search', 'uses' => 'SearchController@all'));



// Shopping cart
Route::get('/shopping-cart.html', array('as' => 'shopping-cart', 'uses' => 'ShoppingController@index'));




// Show checkout form
Route::get('/checkout.html', array('as' => 'checkout', 'uses' => 'CheckoutController@index'));

// Create order
Route::post('/place-order', array('as' => 'place-order', 'uses' => 'CheckoutController@placeOrder'));

// Place order with product
Route::get('/place-order/{id}', 'CheckoutController@withProduct')->where('id', '[0-9]+');




Route::get('/message-to-user.html', array('as' => 'message-to-user', 'uses' => 'HomeController@message'));



// Load partials
Route::get('/partials/{view}.html', function($view)
{
    return View::make('partials.' . $view);
});

// Define cart resource
Route::resource('cart', 'CartController');
Route::resource('product', 'ProductsController');




foreach($routes as $route) $route->where('id', '[0-9]+')->where('category', '[^./]+')->where('product', '[^./]+');









Route::get('kareem', function()
{
    exit();
    foreach(Image::all() as $image)
    {
        foreach($image->versions as $version)
        {
            if(strpos($version->url, 'http://www.qbrando.loc') !== false)
            {
                $version->url = str_replace('http://www.qbrando.loc', 'http://www.qbrando.com', $version->url);
                $version->save();
            }
        }
    }
});

Route::get('/add-offer', function()
{
    exit();
    $offer = Offer::create(array(
        'active' => true
    ));

    $image = Image::create(array('title' => 'Buy 2 get one for free'));

    $image->add(Version::generate('http://www.qbrando.loc/albums/offers/offer3.jpg'));

    $offer->replaceImage($image, 'main');
});

Route::get('/convert-images', function()
{
    exit();
    foreach(Product::all() as $product)
    {
//        dd($product->getImage('main')->getLargest()->url);
        $url = $product->getImage('main')->getLargest()->url;

        $url = str_replace('http://www.qbrando.com', public_path(), $url);
        $url = str_replace('http://qbrando.com', public_path(), $url);

        $img = II::make($url);

        $img->grab(200, 150);

        $imagePath = '/albums/sunglasses/thumbnails/' . $product->brand . '-' . $product->id . '.jpg';

        $img->save(public_path($imagePath));

        $product->getImage('main')->add(new Version(array(
            'url' => 'http://www.qbrando.com' . $imagePath,
            'width' => 200,
            'height' => 150
        )));
    }
});

Route::get('/upload', function()
{
    if(! \Kareem3d\Ecommerce\Product::all()->isEmpty()) return false;

    foreach(glob(public_path('new_uploads/*.txt')) as $file)
    {
        $pathInfo = pathinfo($file);

        $fileName = $pathInfo['filename'];

        $imageName = '';
        $image = null;

        foreach(glob(public_path('new_uploads/'. $fileName .'*.jpg')) as $image)
        {
            $imageName = pathinfo($image);

            $imageName = $imageName['basename'];
        }

        $info = trim(file_get_contents($file));

        $infoLines = explode("\n", $info);

        $product = new Product();

        foreach($infoLines as $line)
        {
            if(strpos($line, '=') !== false)
            {
                $pieces = explode('=', $line);
            }
            elseif(strpos($line, ':') !== false)
            {
                $pieces = explode(':', $line);
            }

            try{
                $key = trim($pieces[0]);
                $value = trim($pieces[1]);
            }catch(Exception $e){dd($e->getMessage(), $pieces);}

            $key = strtolower($key);
            $value = ucfirst(strtolower($value));

            if(strpos($key, 'offer price') !== false) $key = 'offer_price';

            $product->setAttribute($key, $value);
        }

        $product->save();

        // Upload image
        $image = Image::create(array(
            'title' => $product->title
        ));

        $image->add(Version::generate(
            URL::to('new_uploads/' . $imageName)
        ));

        $product->replaceImage($image, 'main');
    }
});

Route::get('/test', function()
{
    exit();
    $offers = Offer::all();
    foreach($offers as $offer) $offer->delete();
//    dd(Cart::find(7));

    $image = \Kareem3d\Images\Image::create(array(
        'title' => 'Buy two get one for free!',
        'alt'   => 'Offer on shades.'
    ));

    $image->add(new \Kareem3d\Images\Version(array(
        'url' => 'http://www.qbrando.loc/app/img/offer.jpg'
    )));

    Offer::create(array(
        'active' => true
    ))->addImage($image, 'main');
//
//    $offer->replaceImage($image, 'main');
});


Route::get('/migrate', function()
{
    Artisan::call('wmigrate');
});