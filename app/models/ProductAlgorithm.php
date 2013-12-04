<?php

use Illuminate\Database\Query\Builder;
use Kareem3d\Ecommerce\Category;
use Kareem3d\Eloquent\Model;

class ProductAlgorithm extends \Kareem3d\Eloquent\Algorithm {

    /**
     * @return $this
     */
    public function available()
    {
        $this->getQuery()->where('available', TRUE);

        return $this;
    }

    /**
     * @param $keyword
     * @return $this
     */
    public function searchByKeyword($keyword)
    {
        $pieces = explode(' ', $keyword);

        $this->getQuery()
            ->join('category_specs', 'category_specs.category_id', '=', 'products.category_id')
            ->select(array('products.*'));

        // First search for models
        $this->getQuery()->where(function($query) use ($pieces)
        {
            foreach($pieces as $piece)
            {
                $model = str_replace('model', '', strtolower($piece));

                if($model) $query->orWhere('product_specs.model', 'like', "%$model%");
            }
        });

        // Now search for categories
        $this->getQuery()->orWhere(function($query) use ($pieces)
        {
            foreach($pieces as $piece)
            {
                if($piece) $query->orWhere('category_specs.title', 'like', "%$piece%");
            }
        });

        return $this;
    }

    /**
     * @param Product $product
     * @return $this
     */
    public function related( Product $product )
    {
        return $this;
    }

    /**
     * @return $this
     */
    public function specials()
    {
        $this->getQuery()->where('offer_price', '!=', 'NULL')->orderBy(DB::raw('RAND()'));

        return $this;
    }

    /**
     * @param $low
     * @param $high
     * @return $this
     */
    public function priceBetween( $low, $high )
    {
        $this->getQuery()->where(function( Builder $query ) use($low, $high) {

            // First we check for the offer price to see if it's set and between the given range
            $query->where('offer_price', '!=', null)->where('offer_price', '>=', $low)->where('offer_price', '<=', $high);

        })->orWhere(function(Builder $query) use($low, $high) {

            // If Offer price wasn't set then get the price between the given range
            $query->where('price', '>=', $low)->where('price', '<=', $high);

        });

        return $this;
    }

    /**
     * @param $gender
     * @return $this
     */
    public function byGender( $gender )
    {
        $gender = strtolower($gender);

        // If it's not unisex then choose the gender or the unisex glasses
        if($gender != 'unisex')
        {
            // Get either the given gender or unisex models...
            $this->getQuery()->where(function( $query ) use ($gender)
            {
                $query->where('gender', $gender)->orWhere('gender', 'unisex');
            });
        }

        return $this;
    }

    /**
     * @param $id
     * @return $this
     */
    public function byColor( $id )
    {
        $id = $this->getId( $id );

        $this->getQuery()->where('color_id', $id);

        return $this;
    }

    /**
     * @param $model
     * @return $this
     */
    public function byModel( $model )
    {
        $model = str_replace('model', '', strtolower($model));
        $model = str_replace(' ', '', strtolower($model));

        $this->getQuery()->where('product_specs.model', 'like', "%$model%");

        return $this;
    }

    /**
     * @param $id
     * @return $this
     */
    public function byCategory( $id )
    {
        $id = $this->getId( $id );

        $this->getQuery()->where('category_id', $id);

        return $this;
    }

    /**
     * @param $id
     * @return mixed
     */
    protected  function getId( $id )
    {
        return is_object($id) ? $id->id : $id;
    }

    /**
     * @return Builder
     */
    public function emptyQuery()
    {
        return Product::specsQuery();
    }
}