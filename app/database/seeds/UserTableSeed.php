<?php
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder {


    public function run()
    {
        User::query()->delete();

        User::create(array(
            'name' => 'Kareem Mohamed',
        ));
    }

}