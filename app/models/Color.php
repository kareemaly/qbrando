<?php

use Kareem3d\Eloquent\Model;

class Color extends Model {

    /**
     * @var string
     */
    protected $table = 'colors';

    /**
     * @var string
     */
    protected $guarded = array();

    /**
     * @var array
     */
    protected static $dontDuplicate = array('title');

    /**
     * @param $title
     * @return mixed
     */
    public static function getByTitle( $title )
    {
        return static::where('title', $title)->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::getClass());
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->title;
    }
}