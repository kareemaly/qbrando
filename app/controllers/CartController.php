<?php

class CartController extends \BaseController {

    /**
     * @var Product
     */
    protected $products;

    /**
     * @var Cart
     */
    protected $cart;

    /**
     * @param Product $products
     */
    public function __construct(Product $products)
    {
        $this->products = $products;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        return array_values(Cart::contents(true));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        return Cart::find( $id );
	}

}