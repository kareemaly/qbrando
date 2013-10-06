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
        return $this->name;
    }
}