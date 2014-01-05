<?php

use Illuminate\Database\Query\Builder;

class CategoryAlgorithm extends \Kareem3d\Eloquent\Algorithm {

    /**
     * Order by categories with the highest number of products, categories that doesn't have any products will not be included.
     *
     * @return $this
     */
    public function orderByProducts()
    {
        $this->getQuery()->join('products', function($query)
        {
            $query->on('products.category_id', '=', 'categories.id')
                  ->on('products.available', '=', DB::raw('1'));
        })
              ->groupBy('categories.id')
              ->orderBy('number_of_products', 'DESC')
              ->select('categories.*', DB::raw('COUNT(*) as number_of_products'));

        return $this;
    }

    /**
     * @return Builder
     */
    public function emptyQuery()
    {
        return Category::query();
    }
}