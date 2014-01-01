<?php

use Illuminate\Support\Facades\View;
use Kareem3d\Controllers\FreakController;

class FreakPaypalPaymentController extends FreakController {

    /**
     * @var PaypalPayment
     */
    protected $paypalPayments;

    /**
     * @var PaypalPayment $paypalPayments
     */
    public function __construct( PaypalPayment $paypalPayments )
    {
        $this->paypalPayments = $paypalPayments;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getIndex()
    {
        $payments = $this->paypalPayments->orderBy('id', 'DESC')->get();

        return View::make('panel::payments.data', compact('payments'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function getShow($id)
    {
        $payment = $this->paypalPayments->with('order')->find( $id );

        $this->setPackagesData($payment);

        return View::make('panel::payments.detail', compact('payment', 'id'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function getDelete($id)
    {
        $this->paypalPayments->find($id)->delete();

        return Redirect::to(freakUrl('element/paypalPayment/'))->with('success', 'PaypalPayment deleted successfully');
    }
}