<?php namespace Kareem3d\Freak;

use Kareem3d\Freak;

interface SynchronisableInterface {

    /**
     * Synchronise client which should create or update the db if needed.
     *
     * @param \Kareem3d\Freak $freak
     * @return void
     */
    public function synchronise( Freak $freak );

}