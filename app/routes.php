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
    exit();
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


Route::get('/facebook', function()
{
    // app_id=577875652285919
    // app_secret=84727ebc3a01c100cc3e6f90190958ea


    //https://www.facebook.com/dialog/oauth?client_id=577875652285919&redirect_uri=http://www.qbrando.com/&scope=manage_pages,publish_stream

    //code=AQDUneG0u3Ceu3utJUp-oujh_PVeKlx_4f__gW0ye2nVaxkkstj1ULBYavlgv_33bryzi5hJXS4fAHCsOG7OkKSGHGZX5yxF7C-iBdcdzVW0KhN0ATvKjSLSy3SEawrTk9eZUp5XQ99Q7z24TMhBwvZBnLcYLAUsmlppWPv47Le-CA_P1xLyyW3d2g1xjonvcyaLW0aV_UhH7xwj5jnDEhFIC0LUpe7n0QMyTjTBN4-in2b3JBVox0NdFZyWYYsQPMiONfKabkH3CyF39qXOWE-cmCcJld-QSMMfcgCahOt-sJQA3Ymuc74AQOrRAxoCvK0

    //https://graph.facebook.com/oauth/access_token?client_id=577875652285919&redirect_uri=http://www.qbrando.com/facebook/&client_secret=84727ebc3a01c100cc3e6f90190958ea&code=AQDUneG0u3Ceu3utJUp-oujh_PVeKlx_4f__gW0ye2nVaxkkstj1ULBYavlgv_33bryzi5hJXS4fAHCsOG7OkKSGHGZX5yxF7C-iBdcdzVW0KhN0ATvKjSLSy3SEawrTk9eZUp5XQ99Q7z24TMhBwvZBnLcYLAUsmlppWPv47Le-CA_P1xLyyW3d2g1xjonvcyaLW0aV_UhH7xwj5jnDEhFIC0LUpe7n0QMyTjTBN4-in2b3JBVox0NdFZyWYYsQPMiONfKabkH3CyF39qXOWE-cmCcJld-QSMMfcgCahOt-sJQA3Ymuc74AQOrRAxoCvK0

    //access_token=CAAVBsGhtWGcBAEs8H69doWBopUZAZC5z99JxMc81i0fki2VlWQjgFkXuWfrCdfJ9S29tEh0SO1R5KFvZBSKQsbOHXiCkN4H6u8ZCN7Uxch4yYckZArwDum4MZA8QXlNRhEX09AjP9LAHt1EJKXedyHHKZAYuSeHTq7xjqCGFuvEgmvr3zD9du4H&expires=5183900

    //https://graph.facebook.com/me/accounts?access_token=CAAVBsGhtWGcBAEs8H69doWBopUZAZC5z99JxMc81i0fki2VlWQjgFkXuWfrCdfJ9S29tEh0SO1R5KFvZBSKQsbOHXiCkN4H6u8ZCN7Uxch4yYckZArwDum4MZA8QXlNRhEX09AjP9LAHt1EJKXedyHHKZAYuSeHTq7xjqCGFuvEgmvr3zD9du4H

    //page_access_token=CAAVBsGhtWGcBAGFp88EWZA0RdT4p8fPr1PZC34bZBMYhCDzNl7EW3BhZAV4tuAfopPqZAKY4hZBfhPWjZBHgaA85HHkQ9L2R1avas3foQ5cCeecyYK8p5sYOr4xa0gCmnMbjx8cMh28qSmqWQMqUBSeT1YQXH6oCbmN0xaC1ZChj5l6aKSgBHieb
    //page_id=277738978965645

    dd($_GET);
});


Route::get('/post-to-facebook', function()
{
//    $config = array();
//    $config['appId'] = '1479600805599335';
//    $config['secret'] = 'aa0ba0e9ec5dbdda354ff31075998fc0';
//    $config['fileUpload'] = false; // optional
//    $fb = new Facebook($config);
//
//    $params = array(
//        // this is the access token for Fan Page
//        "access_token" => "CAAVBsGhtWGcBAGFp88EWZA0RdT4p8fPr1PZC34bZBMYhCDzNl7EW3BhZAV4tuAfopPqZAKY4hZBfhPWjZBHgaA85HHkQ9L2R1avas3foQ5cCeecyYK8p5sYOr4xa0gCmnMbjx8cMh28qSmqWQMqUBSeT1YQXH6oCbmN0xaC1ZChj5l6aKSgBHieb",
//        "message" => "Here is a blog post about auto posting on Facebook using PHP #php #facebook",
//        "link" => "http://www.pontikis.net/blog/auto_post_on_facebook_with_php",
//        "picture" => "http://i.imgur.com/lHkOsiH.png",
//        "name" => "How to Auto Post on Facebook with PHP",
//        "caption" => "www.pontikis.net",
//        "description" => "Automatically post on Facebook with PHP using Facebook PHP SDK. How to create a Facebook app. Obtain and extend Facebook access tokens. Cron automation."
//    );
//
//    try {
//        // 466400200079875 is Facebook id of Fan page https://www.facebook.com/pontikis.net
//        $ret = $fb->api('/277738978965645/feed', 'POST', $params);
//        echo 'Successfully posted to Facebook Fan Page';
//    } catch(Exception $e) {
//        echo $e->getMessage();
//    }
});



Route::get('/migrate', function()
{
    Artisan::call('wmigrate');
});