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
        return array_values(Cart::getProducts(true));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        Cart::addProduct($this->getProduct());

        return array('status' => 'success');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        return Cart::getProduct( $id );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        Cart::update($id, Input::get('item'));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        Cart::find($id)->remove();
	}

    /**
     * @return Product
     */
    protected function getProduct()
    {
        return $this->products->find(Input::get('productId'));
    }

}