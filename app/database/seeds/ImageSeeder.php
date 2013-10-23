<?php

use Kareem3d\Code\Code;
use Kareem3d\Images\Group;
use Kareem3d\Images\Specification;

class ImageSeeder extends \Illuminate\Database\Seeder{

    public function run()
    {
        Group::query()->delete();
        Specification::query()->delete();



        $group = Group::create(array(
            'name' => 'Product.Main'
        ));

        $group->specs()->create(array(
            'directory' => 'albums/sunglasses/thumbnails'
        ))->setCode(new Code(array(
                'code' => '$image->grab(200, 150); return $image;'
            )));

        $group->specs()->create(array(
            'directory' => 'albums/sunglasses/normal'
        ));

    }
}