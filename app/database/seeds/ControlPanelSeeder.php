<?php

use Kareem3d\Freak\DBRepositories\ControlPanel;

class ControlPanelSeeder extends \Illuminate\Database\Seeder {

    /**
     *
     */
    public function run()
    {
        ControlPanel::query()->delete();
        User::query()->delete();

        ControlPanel::create(array(
            'name' => 'QBrando',
            'password' => 'q-brando123'
        ));
    }
}