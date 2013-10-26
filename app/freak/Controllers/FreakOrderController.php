<?php

use Illuminate\Support\Facades\View;
use Kareem3d\Controllers\FreakController;
use Kareem3d\Ecommerce\Order;

class FreakOrderController extends FreakController {

    /**
     * @var Order
     */
    protected $orders;

    /**
     * @var Order $orders
     */
    public function __construct( Order $orders )
    {
        $this->orders = $orders;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getIndex()
    {
        $orders = $this->orders->get();

        return View::make('panel::orders.data', compact('orders'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function getShow($id)
    {
        $order = $this->orders->with('products')->find( $id );

        $total = 0;

        foreach($order->products as $product)
        {
            $total += $product->actualPrice->value() * $product->pivot->qty;
        }

        $this->setPackagesData($order);

        return View::make('panel::orders.detail', compact('order', 'id', 'total'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function getDelete($id)
    {
        $this->orders->find($id)->delete();

        return $this->redirectBack('Order deleted successfully.');
    }
}