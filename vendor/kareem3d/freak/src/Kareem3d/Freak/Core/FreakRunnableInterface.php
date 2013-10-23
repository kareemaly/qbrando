<?php namespace Kareem3d\Freak\Core;

use Kareem3d\Freak;

interface FreakRunnableInterface {

    /**
     * Load client configurations
     *
     * @param \Kareem3d\Freak $freak
     * @return void
     */
    public function run( Freak $freak );

}