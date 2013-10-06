<?php

use Kareem3d\Ecommerce\Product as Kareem3dProduct;

class Product extends Kareem3dProduct {

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