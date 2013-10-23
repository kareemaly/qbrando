<?php

use Illuminate\Support\Str;

class Category extends Kareem3d\Ecommerce\Category implements SlugInterface{

    /**
     * @return mixed
     */
    public function beforeSave()
    {
        return DB::table(static::$specsTable)->where('title', $this->title);
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return Str::slug(Str::words($this->title, 3, ''));
    }

    /**
     * @return mixed
     */
    public function __toString()
    {
        return $this->title;
    }
}