<?php

use Illuminate\Database\Eloquent\Collection;

class Offer extends \Kareem3d\Eloquent\Model {

    /**
     * @var array
     */
    protected $extensions = array('Images');

    /**
     * @var string
     */
    protected $table = 'offers';

    /**
     * @var array
     */
    protected $guarded = array();

    /**
     * @return Collection
     */
    public static function getActive()
    {
        return static::where('active', true)->get();
    }

}