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

// Shopping cart
Route::get('/shopping-cart.html', array('as' => 'shopping-cart', 'uses' => 'ShoppingController@index'));

// Search sunglasses
Route::get('/search-sunglasses.html', array('as' => 'search-products', 'uses' => 'SearchController@products'));

// Search the whole website
Route::get('/search.html', array('as' => 'search', 'uses' => 'SearchController@all'));

// Show checkout form
Route::get('/checkout.html', array('as' => 'checkout', 'uses' => 'CheckoutController@index'));

// Create order
//Route::post('/checkout.html', 'CheckoutController@createOrder');

// Define cart resource
Route::resource('cart', 'CartController');

Route::get('/partials/product/{id}', function( $id )
{
    $product = Product::findOrFail($id);

    return View::make('partials.main_product', compact('product'));
});






foreach($routes as $route) $route->where('id', '[0-9]+')->where('category', '[^./]+')->where('product', '[^./]+');











Route::get('kareem', function()
{
    foreach(Image::all() as $image)
    {
        foreach($image->versions as $version)
        {
            if(strpos($version->url, 'http://www.qbrando.loc') !== false)
            {
                $version->url = str_replace('http://www.qbrando.loc', 'http://www.qbrando.com/public', $version->url);
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
    foreach(Product::all() as $product)
    {
        $url = $product->getImage('main')->getLargest()->url;

        $url = str_replace('http://www.qbrando.loc', public_path(), $url);

        $thumbnail = '200x150';

        $img = II::make($url);

        $img->grab(200, 150);

        $imagePath = '/albums/sunglasses/thumbnails/' . $product->brand . '-' . $product->id . '.jpg';

        $img->save(public_path($imagePath));

        $product->getImage('main')->add(new Version(array(
            'url' => 'http://www.qbrando.loc' . $imagePath,
            'width' => 200,
            'height' => 150
        )));
    }
});

Route::get('/upload', function()
{
    if(! \Kareem3d\Ecommerce\Product::all()->isEmpty()) return false;
    foreach(glob(public_path('uploads/*.txt')) as $file)
    {
        $pathInfo = pathinfo($file);

        $fileName = $pathInfo['filename'];

        $imageName = '';
        $image = null;

        foreach(glob(public_path('uploads/'. $fileName .'*.jpg')) as $image)
        {
            $imageName = pathinfo($image);

            $imageName = $imageName['basename'];
        }

        $info = trim(file_get_contents($file));

        $infoLines = explode("\n", $info);

        $product = new Product();

        foreach($infoLines as $line)
        {
            $pieces = explode('=', $line);

            $key = trim($pieces[0]);
            $value = trim($pieces[1]);

            $key = strtolower($key);
            $value = ucfirst(strtolower($value));

            if($key == 'offer') $key = 'offer_price';

            $product->setAttribute($key, $value);
        }

        $product->save();


        // Upload image
        $image = Image::create(array(
            'title' => $product->title
        ));

        $image->add(Version::generate(
            URL::to('uploads/' . $imageName)
        ));

        $product->replaceImage($image, 'main');
    }
});

Route::get('/test', function()
{
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

