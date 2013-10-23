<?php

use Kareem3d\Ecommerce\Category;

class CategoryController extends \BaseController {

    /**
     * @var Kareem3d\Ecommerce\Category
     */
    protected $categories;

    /**
     * @var ProductAlgorithm
     */
    protected $productsAlgorithm;

    /**
     * @param Category $categories
     * @param ProductAlgorithm $productsAlgorithm
     */
    public function __construct( Category $categories, ProductAlgorithm $productsAlgorithm )
    {
        $this->categories = $categories;
        $this->productsAlgorithm = $productsAlgorithm;
    }

    /**
     * @param $category
     * @param $id
     * @return void
     */
    public function show( $category, $id )
    {
        $category = $this->categories->findOrFail($id);

        $products = $this->productsAlgorithm->byCategory($category)->orderByDate()->paginate( self::PER_PAGE );

        $productsTitle = "Showing $category->title sunglasses ";

        $this->layout->template->addPart('body', array('products'), compact('products', 'productsTitle'));
    }

}