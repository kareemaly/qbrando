<?php

use Kareem3d\Ecommerce\Category;
use Kareem3d\Ecommerce\Product as Kareem3dProduct;

class Product extends Kareem3dProduct {

    /**
     * @var array
     */
    protected $extensions = array('Images');

    /**
     * @param  string $value
     * @return string
     */
    public function getTitleAttribute( $value )
    {
        return $value ?: 'Model ' . $this->model;
    }

    /**
     * @param $value
     * @return string
     */
    public function getOfferPriceAttribute( $value )
    {
        return $value . ' QR';
    }

    /**
     * @param $value
     * @return string
     */
    public function getPriceAttribute( $value )
    {
        return $value . ' QR';
    }

    /**
     * @param $value
     */
    public function setOfferAttribute( $value )
    {
        $this->attributes['offer_price'] = $value;
    }

    /**
     * @param $value
     */
    public function setColorAttribute( $value )
    {
        $color = Color::create(array('name' => $value));

        $this->attributes['color_id'] = $color->id;
    }

    /**
     * @param $value
     */
    public function setBrandAttribute( $value )
    {
        $category = Category::create(array('name' => $value));

        $this->attributes['category_id'] = $category->id;
    }

    /**
     * @return string
     */
    public function getBrandAttribute()
    {
        return $this->category ? $this->category->name : '';
    }

    /**
     * @return bool
     */
    public function hasColor()
    {
        return $this->color()->count() > 0;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function color()
    {
        return $this->belongsTo(Color::getClass());
    }
}