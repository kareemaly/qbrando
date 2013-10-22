<?php

use Kareem3d\Ecommerce\Category;

class SearchController extends BaseController {

    /**
     * @var ProductAlgorithm
     */
    protected $productsAlgorithm;

    /**
     * @var Kareem3d\Ecommerce\Category
     */
    protected $categories;

    /**
     * @var Color
     */
    protected $colors;

    /**
     * @param ProductAlgorithm $productsAlgorithm
     * @param Kareem3d\Ecommerce\Category $categories
     * @param Color $colors
     */
    public function __construct( ProductAlgorithm $productsAlgorithm, Category $categories, Color $colors )
    {
        $this->productsAlgorithm = $productsAlgorithm;
        $this->categories = $categories;
        $this->colors = $colors;
    }

    /**
     * @return mixed
     */
    public function getIndex()
    {
        $productsTitle = 'Showing ';

        if($category = $this->getCategory( Input::get('category') ))
        {
            $productsTitle .= $category->name . ', ';

            $this->productsAlgorithm->byCategory( $category );
        }

        if($color = $this->getColor( Input::get('color') ))
        {
            $productsTitle .= $color->name;

            $this->productsAlgorithm->byColor( $color );
        }

        $products = $this->productsAlgorithm->paginate( 12 );

        $productsTitle = rtrim($productsTitle, ', ');
        $productsTitle .= ' products';


        return View::make('pages.home', compact('products', 'productsTitle'));
    }

    /**
     * @param $categoryName
     * @return Category
     */
    public function getCategory( $categoryName )
    {
        return $this->categories->where('name', $categoryName)->first();
    }

    /**
     * @param $colorName
     * @return Color
     */
    public function getColor( $colorName )
    {
        return $this->colors->where('name', $colorName)->first();
    }

}