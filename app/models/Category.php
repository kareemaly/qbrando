<?php

use Illuminate\Support\Str;

class Category extends Kareem3d\Ecommerce\Category implements SlugInterface{

    /**
     * @return \Illuminate\Support\Collection
     */
    public static function getNotEmpty()
    {
        return static::whereIn('id', function( $query )
        {
            $query->from('products');

            $query->distinct();
            $query->select('category_id');

            return $query;
        })->get();
    }

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