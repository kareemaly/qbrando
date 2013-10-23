<?php

use Kareem3d\Ecommerce\Category;
use Kareem3d\Ecommerce\Product as Kareem3dProduct;

class Product extends Kareem3dProduct implements SlugInterface {


    /**
     * @var array
     */
    protected static $specs = array(
        'title', 'model', 'gender'
    );

    /**
     * @var string
     */
    protected $currency = 'Q.R';

    /**
     * @return array
     */
    public static function getGenders()
    {
        return array('male', 'female', 'unisex');
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return Str::slug(Str::words($this->title, 3, ''));
    }

    /**
     * @param  string $value
     * @return string
     */
    public function getTitleAttribute( $value )
    {
        if($value) return $value;

        return $this->model ? 'Model ' .$this->model : '';
    }

    /**
     * @param $value
     */
    public function setColorAttribute( $value )
    {
        $color = Color::create(array('title' => $value));

        $this->attributes['color_id'] = $color->id;
    }

    /**
     * @param $value
     */
    public function setBrandAttribute( $value )
    {
        $category = new Category(array('title' => $value));

        $category->save();

        $this->attributes['category_id'] = $category->id;
    }

    /**
     * @return string
     */
    public function getBrandAttribute()
    {
        return $this->category ? $this->category->title : '';
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