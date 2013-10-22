<?php

// Home controller route
use Kareem3d\Images\Image;
use Kareem3d\Images\Version;

use Intervention\Image\Image as II;

Route::get('/', function(){ return Redirect::to('/home'); });

Route::controller('/home', 'HomeController');

// Search controller
Route::controller('/search.html', 'SearchController');

// Load partials
Route::controller('/partials', 'PartialsController');



Route::get('kareem', function()
{
    foreach(Image::all() as $image)
    {
        foreach($image->versions as $version)
        {
            if(strpos($version->url, 'http://www.qbrando.com') !== false)
            {
                $version->url = str_replace('http://www.qbrando.com', 'http://www.qbrando.com/public', $version->url);
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
    dd(Cart::find(7));

//    $image = \Kareem3d\Images\Image::create(array(
//        'title' => 'Buy two get one for free!',
//        'alt'   => 'Offer on shades.'
//    ));
//
//    $image->add(new \Kareem3d\Images\Version(array(
//        'url' => 'http://www.qbrando.loc/app/img/offer3.jpg'
//    )));
//
//    Offer::create(array(
//        'active' => true
//    ))->addImage($image, 'main');

//    $offer->replaceImage(, 'main');
});


// Define resources
Route::resource('category', 'CategoryController', array(
    'only' => array('index', 'show')
));

Route::resource('offer', 'OfferController', array(
    'only' => array('index', 'show')
));

Route::resource('product', 'ProductController', array(
    'only' => array('index', 'show')
));

Route::resource('order', 'OrderController', array(
    'only' => array('store')
));

Route::resource('cart', 'CartController');