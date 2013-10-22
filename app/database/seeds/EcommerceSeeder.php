<?php

use Kareem3d\Ecommerce\Category;

class EcommerceSeeder extends \Illuminate\Database\Seeder {


    public function run()
    {
        Product::query()->delete();
        Category::query()->delete();

        $category1 = Category::create(array(
            'name' => 'Britsby'
        ));

        $category2 = Category::create(array(
            'name' => 'Shine'
        ));

        $category1->products()->create(array(
            'title' => 'Shade 1',
            'gender' => 'male',
            'model' => 'Model-x45',
            'price' => '400',
        ));

        $category1->products()->create(array(
            'title' => 'Shade 2',
            'gender' => 'male',
            'model' => 'Model-x45',
            'price' => '400',
        ));

        $category1->products()->create(array(
            'title' => 'Shade 3',
            'gender' => 'male',
            'model' => 'Model-x45',
            'price' => '400',
        ));

        $category2->products()->create(array(
            'title' => 'Shade 5',
            'gender' => 'male',
            'model' => 'Model-x45',
            'price' => '400',
        ));

        $category2->products()->create(array(
            'title' => 'Shade 4',
            'gender' => 'male',
            'model' => 'Model-x45',
            'price' => '400',
        ));
    }
}