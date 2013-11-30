<?php

class DatabaseSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();
//
//        $this->call('EcommerceSeeder');
//
//        $this->call('UserTableSeeder');

        $this->call('ControlPanelSeeder');

        $this->call('ImageSeeder');
    }
}