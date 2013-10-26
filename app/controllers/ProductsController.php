<?php 

class ProductsController extends BaseController {

    /**
     * @var Color
     */
    protected $products;

    /**
     * Product $products
     */
    public function __construct( Product $products )
    {
        $this->products = $products;
    }

    /**
     * @param $id
     * @return string
     */
    public function show( $id )
    {
        return Response::json($this->products->findOrFail($id)->allAttributes());
    }
}