<?php

use Kareem3d\Ecommerce\Category;

class ProductController extends BaseController {

    /**
     * @var Color
     */
    protected $products;

    /**
     * @var ProductAlgorithm
     */
    protected $productsAlgorithm;

    /**
     * Product $products
     */
    public function __construct( Product $products, ProductAlgorithm $productsAlgorithm )
    {
        $this->products = $products;
        $this->productsAlgorithm = $productsAlgorithm;
    }

    /**
     * @param $category
     * @param $product
     * @param $id
     * @return void
     */
    public function show( $category, $product, $id )
    {
        $product = $this->products->findOrFail($id);

        $products = $this->productsAlgorithm->related( $product )->paginate(self::PER_PAGE);

        $productsTitle = 'Related sunglasses';

        $brightTitle = true;

        $this->layout->template->addPart('body', array('product', 'products'), compact('products', 'productsTitle', 'product', 'brightTitle'));
    }
}