<?php 

class PartialsController extends BaseController {

    /**
     * @var Product
     */
    protected $products;

    /**
     * @param Product $products
     */
    public function __construct( Product $products )
    {
        $this->products = $products;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getProduct( $id )
    {
        $product = $this->products->find( $id );

        return View::make('partials.main_product', compact('product'));
    }

}