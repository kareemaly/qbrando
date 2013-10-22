<?php

class CartController extends \BaseController {

    /**
     * @var Product
     */
    protected $products;

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
        return Cart::contents();
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $product = $this->getProduct();

        Cart::insert(array(
            'id'       => $product->id,
            'name'     => $product->title,
            'price'    => $product->price,
            'quantity' => 1,
        ));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        return $this->cart->item( $id );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        $this->cart->update($id, Input::get('item'));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $this->cart->item($id)->remove();
	}

    /**
     * @return Product
     */
    protected function getProduct()
    {
        return $this->products->find(Input::get('productId'));
    }

}