<?php

class ProductController extends \BaseController {

    /**
     * @var Product
     */
    protected $products;

    /**
     * @var ProductAlgorithm
     */
    protected $productsAlgorithm;

    /**
     * @param Product $products
     * @param ProductAlgorithm $productsAlgorithm
     */
    public function __construct( Product $products, ProductAlgorithm $productsAlgorithm )
    {
        $this->products = $products;
        $this->productsAlgorithm = $productsAlgorithm;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        if($category_id = Input::get('category_id'))

            $this->productsAlgorithm->byCategory($category_id);

        if($color_id = Input::get('color_id'))

            $this->productsAlgorithm->byColor($color_id);

        return $this->productsAlgorithm->get();
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        return $this->products->find($id);
	}

}