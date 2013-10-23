<?php

use Kareem3d\Images\Image;
use Kareem3d\Images\Version;
use Intervention\Image\Image as II;

class EcommerceSeeder extends \Illuminate\Database\Seeder {


    public function run()
    {
        Product::query()->delete();
        Category::query()->delete();
        Offer::query()->delete();

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





        $offer = Offer::create(array(
            'active' => true
        ));

        $image = Image::create(array('title' => 'Buy 2 get one for free'));

        $image->add(Version::generate('http://www.qbrando.loc/albums/offers/offer.jpg'));

        $offer->replaceImage($image, 'main');
    }

}