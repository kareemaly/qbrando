<?php

use Illuminate\Support\Facades\View;
use Kareem3d\Controllers\FreakController;

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
     * @return mixed
     */
    public function getWow()
    {
        if(Input::get('from_date') && Input::get('to_date'))
        {
            $from = date('Y-m-d H:i:s', strtotime(Input::get('from_date')));
            $to   = date('Y-m-d H:i:s', strtotime(Input::get('to_date')));

            $orders = $this->orders->byDateRange($from, $to);
        }

        else
        {
            $orders = $this->orders->get();
        }

        return View::make('panel::orders.wow', compact('orders'));
    }

    /**
     * @return void
     */
    public function postWow()
    {
        $inputs = Input::all();

        foreach($inputs as $input)
        {
            if(! $order = $this->orders->find($input['id'])) return false;

            $order->status = $input['status'];

            $order->save();
        }
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