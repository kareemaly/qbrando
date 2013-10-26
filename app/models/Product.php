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
    protected $currency = 'QAR';

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
     * @param $value
     * @return string
     */
    public function getGenderAttribute( $value )
    {
        return $value ?: 'unisex';
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

    /**
     * @return string|void
     */
    public function allAttributes()
    {
        $attributes = $this->toArray();

        $newAttributes = array();

        // Get attributes
        foreach($attributes as $key => $attribute)
        {
            $newAttributes[ $key ] = (string) $attribute;
        }

        // Load specification attributes
        foreach(static::$specs as $attr)
        {
            $newAttributes[$attr] = $this->$attr;
        }

        $newAttributes['beforePrice'] = (string) $this->beforePrice;
        $newAttributes['actualPrice'] = (string) $this->actualPrice;

        $newAttributes['brand'] = $this->brand;

        // Load image
        $newAttributes['image'] = $this->getImage('main')->getSmallest()->url;
        $newAttributes['largeImage'] = $this->getImage('main')->getLargest()->url;

        return $newAttributes;
    }
}