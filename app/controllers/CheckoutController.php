<?php

use PayPal\CoreComponentTypes\BasicAmountType;
use PayPal\EBLBaseComponents\DoExpressCheckoutPaymentRequestDetailsType;
use PayPal\EBLBaseComponents\PaymentDetailsType;
use PayPal\EBLBaseComponents\SetExpressCheckoutRequestDetailsType;
use PayPal\PayPalAPI\DoExpressCheckoutPaymentReq;
use PayPal\PayPalAPI\DoExpressCheckoutPaymentRequestType;
use PayPal\PayPalAPI\GetExpressCheckoutDetailsReq;
use PayPal\PayPalAPI\GetExpressCheckoutDetailsRequestType;
use PayPal\PayPalAPI\GetExpressCheckoutDetailsResponseType;
use PayPal\PayPalAPI\SetExpressCheckoutReq;
use PayPal\PayPalAPI\SetExpressCheckoutRequestType;
use PayPal\Service\PayPalAPIInterfaceServiceService;

class CheckoutController extends BaseController {

    /**
     * @var Order
     */
    protected $orders;

    /**
     * @var UserInfo
     */
    protected $userInfo;

    /**
     * @var Product
     */
    protected $products;

    /**
     * @var Country
     */
    protected $countries;

    /**
     * @var Location
     */
    protected $locations;

    /**
     * @var \Illuminate\Support\MessageBag
     */
    protected $errors;

    /**
     * @var PaypalPayment
     */
    protected $paypalPayments;

    /**
     * @var PriceAmount
     */
    protected $amounts;

    /**
     * @param Product $products
     * @param Order $orders
     * @param UserInfo $userInfo
     * @param Country $countries
     * @param Location $locations
     * @param PaypalPayment $paypalPayments
     * @param PriceAmount $amounts
     */
    public function __construct(Product $products, Order $orders, UserInfo $userInfo,
                                Country $countries, Location $locations, PaypalPayment $paypalPayments,
                                PriceAmount $amounts)
    {
        $this->orders = $orders;
        $this->userInfo = $userInfo;
        $this->products = $products;
        $this->countries = $countries;
        $this->locations = $locations;
        $this->paypalPayments = $paypalPayments;
        $this->amounts = $amounts;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        if(Cart::totalWithOffer() == 0)
        {
            return Redirect::route('shopping-cart');
        }

        $jsObject = $this->countries->jsObject();

        $conversionRate = $this->conversionRate('QAR', 'USD');

        $this->layout->template->addPart('body', array('new_checkout'), compact('jsObject', 'conversionRate'));

//        $this->layout->template->addPart('head', array('facebook_conversation_pixel'));
    }

    /**
     * @return mixed
     */
    public function postCreateOrder()
    {
        // Create user and location
        list($userInfo, $deliveryLocation)=  $this->createUserAndLocation();

        // If there were errors
        if(! $this->emptyErrors()) return $this->redirectBackWithErrors();;

        // First create order
        $order = $this->createOrder($userInfo, $deliveryLocation);

        // Add order products
        $this->addOrderProducts($order);

        // Now check the payment method
        if(Input::get('Payment.method') == 'paypal')
        {
            $return = $this->setExpressCheckout($this->convertFromQARToUSD($order->getOfferPrice()));

            $this->createPaypalPayment($order, $return['token']);

            // Redirect to paypal
            return Redirect::to($return['url']);
        }

        // If payment method is pay on delivery then just show him a thank you message
        else
        {
            // Clear cart
            Cart::destroy();

            $this->messageToUser(
                'Thanks '. ucfirst($order->userInfo->first_name) .'! Order has been placed successfully.',
                'We will contact you soon at <span style="color:#C20676">'.$order->userInfo->contact_number.'</span>
                to confirm time of delivery and shipping address.<br /><br />
                 Thank you for choosing QBrando <strong>online shop for luxury in Qatar</strong><br /><br />
                <a href='.URL::route('home').'>Go back home</a>'
            );
        }
    }

    /**
     * This will create empty order along with the paypal payment awaiting with the token and redirect to paypal.
     *
     * @return mixed
     */
    public function checkOutWithPaypal()
    {
        // Create empty order and add cart products to it
        $order = $this->createEmptyOrder();
        $this->addOrderProducts($order);

        $return = $this->setExpressCheckout($order);

        // Create new paypal payment awaiting with the given token
        $this->createPaypalPayment($order, $return['token']);

        // Redirect to paypal
        return Redirect::to($return['url']);
    }

    /**
     * @throws PaypalException
     * @return mixed
     */
    public function postFillAndConfirmPaypalPayment()
    {
        // Get paypal payment by token
        if(! $paypalPayment = $this->paypalPayments->getByToken(Input::get('token'))) throw new PaypalException('Error Code:C54; Something went wrong. Please try again.');

        // Get order associated with the paypal payment
        $order = $paypalPayment->order;

        // Create user and location
        list($userInfo, $location) = $this->createUserAndLocation();

        // If errors occured then redirect back with errors
        if(! $this->emptyErrors()) $this->redirectBackWithErrors();

        // Associate order with user and delivery location
        $order->userInfo()->associate($userInfo);
        $order->deliveryLocation()->associate($location);

        // Save order
        $order->save();

        // Confirm paypal payment
        return $this->postConfirmPaypalPayment();
    }

    /**
     * @throws PaypalException
     * @return mixed
     */
    public function postConfirmPaypalPayment()
    {
        $payerID = Input::get('payerID');
        $token = Input::get('token');

        if(! $paypalPayment = $this->paypalPayments->getByToken($token)) throw new PaypalException('In postConfirmPaypalPayment: Couldn\'t get paypalPayment by token.');

        $transaction = $this->doExpressCheckout($paypalPayment, $payerID);

        // Set fee amount for this payment
        $feeAmount = $this->amounts->create(array(
            'value' => $transaction['feeAmount']->value,
            'currency' => $transaction['feeAmount']->currencyID
        ));
        $paypalPayment->feeAmount()->associate($feeAmount);

        $paypalPayment->transaction_id = $transaction['transactionID'];
        // Mark this payment as received and push it to database
        $paypalPayment->received();
        $paypalPayment->save();

        // Destroy cart
        Cart::destroy();

        $this->messageToUser(
            'Thanks '. ucfirst($paypalPayment->order->userInfo->first_name) .'! Order has been placed successfully.',

            'We have received '.$paypalPayment->grossAmount->format().' From your Paypal account <br /><br />

            We will contact you soon at <span style="color:#C20676">'.$paypalPayment->order->userInfo->contact_number.'</span>
                to confirm time of delivery and shipping address.<br /><br />

            Thank you for choosing QBrando <strong>online shop for luxury in Qatar</strong><br />

                <a href='.URL::route('home').'>Go back home</a>'
        );
    }

    /**
     * @return mixed
     */
    public function paypalBackSucceed()
    {
        $token = Input::get('token');

        $paypalPayment = $this->paypalPayments->getByToken($token);
        $response = $this->getExpressCheckoutDetails($token);
        $order = $paypalPayment->order;

        $paypal = $this->extractExpressCheckoutRequiredInfo($response);

        // Add gross amount to the paypal payment
        $grossAmount = $this->amounts->create(array(
            'value' => $paypal['order']['total'],
            'currency' => $paypal['order']['currency'],
        ));
        $paypalPayment->grossAmount()->associate($grossAmount);
        $paypalPayment->save();

        $countries = $this->countries->all();

        $data = compact('countries', 'paypal', 'order', 'token');

        if($order->isEmpty())
        {
            // Here I should display the paypal order details,
            // ask the user to confirm payment and fill the rest of information
            $this->layout->template->addPart('body', array('fill_and_confirm_paypal'), $data);
        }
        else
        {
            $this->layout->template->addPart('body', array('confirm_paypal'), $data);
        }

        $this->layout->template->addPart('scripts', array('map_scripts'));
    }

    /**
     * If paypal canceled then show him the checkout again
     *
     * @return mixed
     */
    public function paypalBackCanceled()
    {
        $token = Input::get('token');

        $paypalPayment = $this->paypalPayments->getByToken($token);
        $paypalPayment->canceled();
        $paypalPayment->save();

        return Redirect::route('checkout');
    }

    /**
     * @param $id
     * @return mixed
     */
    public function withProduct( $id )
    {
        // First add product to cart then redirect to checkout
        $product = $this->products->findOrFail($id);

        //
        Cart::addProduct($product);

        // Show the checkout page
        return Redirect::route('checkout');
    }

    /**
     * @return Order
     */
    protected function createEmptyOrder()
    {
        $order = $this->orders->create(array());

        return $order;
    }

    /**
     * Create order associated with the user information and delivery location
     * @param $userInfo
     * @param $deliveryLocation
     * @param Order|null $order
     * @return Order
     */
    protected function createOrder($userInfo, $deliveryLocation, Order $order = null)
    {
        // Create new instance or use the given order
        $order = $order ?: $this->orders->newInstance();

        // Set order user information
        $order->userInfo()->associate($userInfo);

        // Set order delivery location
        $order->deliveryLocation()->associate($deliveryLocation);

        // Save order to database
        $order->save();

        return $order;
    }

    /**
     * @return array
     */
    protected function createUserAndLocation()
    {
        // Create and validate user information
        $userInfo = $this->userInfo->newInstance(Input::get('UserInfo'));

        // Create and validate new delivery location instance
        $deliveryLocation = $this->locations->newInstance(Input::get('DeliveryLocation'));

        // If user info not valid or delivery location not valid then append errors
        if(! $deliveryLocation->isValid() || ! $userInfo->isValid())
        {
            $this->addErrors($userInfo);
            $this->addErrors($deliveryLocation);
        }

        // User info and delivery location are valid
        else
        {
            // Save delivery and user information
            $userInfo->save() && $deliveryLocation->save();
        }

        return array($userInfo, $deliveryLocation);
    }

    /**
     * @param Order $order
     */
    protected function addOrderProducts(Order $order)
    {
        // Add cart products to order
        foreach(Cart::contents() as $item)
        {
            $product = $this->products->findOrFail($item->id);

            $order->addProduct( $product, $item->quantity );
        }
    }

    /**
     * @param Order $order
     * @param $token
     */
    protected function createPaypalPayment(Order $order, $token)
    {
        // Create new paypal payment with awaiting state and given token
        $paypalPayment = $this->paypalPayments;
        $paypalPayment = $paypalPayment->newInstance(array(

            'status' => $paypalPayment::AWAITING,
            'token' => $token
        ));
        $order->paypalPayments()->save($paypalPayment);
    }

    /**
     * GetExpressCheckoutDetails
     *
     * @param $token
     * @throws PaypalException
     * @return array
     */
    protected function getExpressCheckoutDetails($token)
    {
        try{
            $getExpressCheckoutDetailsRequest = new GetExpressCheckoutDetailsRequestType($token);

            $getExpressCheckoutReq = new GetExpressCheckoutDetailsReq();
            $getExpressCheckoutReq->GetExpressCheckoutDetailsRequest = $getExpressCheckoutDetailsRequest;

            $paypalService = new PayPalAPIInterfaceServiceService(Config::get('paypal.settings'));

            // If exception was thrown then laravel exception handling will handle it /:)
            $getECResponse = $paypalService->GetExpressCheckoutDetails($getExpressCheckoutReq);

        }catch(Exception $e) {

            throw new PaypalException("In getExpressCheckoutDetails: {$e->getMessage()}");
        }

        if(isset($getECResponse) && strtoupper($getECResponse->Ack) == 'SUCCESS') {

            return $getECResponse;
        }

        throw new PaypalException("In getExpressCheckoutDetails: Response is not success");
    }

    /**
     * Make SetExpressCheckout API call and get the token from the response. Then redirect
     * the user to the paypal site with this token.
     *
     * @param $totalPrice
     * @throws PaypalException
     * @return mixed
     */
    protected function setExpressCheckout($totalPrice)
    {
        try{
            $returnUrl = URL::route('paypal.succeed');
            $cancelUrl = URL::route('paypal.canceled');

            // details about payment
            $paymentDetails = new PaymentDetailsType();

            // Do something to show the order summery
            // total order amount
            $paymentDetails->OrderTotal = new BasicAmountType(Config::get('paypal.payment.currency'), $totalPrice);

            $paymentDetails->PaymentAction = Config::get('paypal.payment.action');

            $setECReqDetails = new SetExpressCheckoutRequestDetailsType();
            $setECReqDetails->PaymentDetails[0] = $paymentDetails;
            $setECReqDetails->CancelURL = $cancelUrl;
            $setECReqDetails->ReturnURL = $returnUrl;

            $setECReqType = new SetExpressCheckoutRequestType();
            $setECReqType->SetExpressCheckoutRequestDetails = $setECReqDetails;
            $setECReq = new SetExpressCheckoutReq();
            $setECReq->SetExpressCheckoutRequest = $setECReqType;

            $paypalService = new PayPalAPIInterfaceServiceService(Config::get('paypal.settings'));

            // If any exception thrown it will be caught by laravel exception handling system
            $setECResponse = $paypalService->SetExpressCheckout($setECReq);

        }catch(Exception $e) {

            throw new PaypalException("In getExpressCheckoutDetails: {$e->getMessage()}");
        }

        if(isset($setECResponse) && strtoupper($setECResponse->Ack) == 'SUCCESS')
        {
            $token = $setECResponse->Token;

            $url = Config::get('paypal.url') . '?cmd=_express-checkout&token=' . $token . '&useraction=commit';

            return compact('token', 'url');
        }

        throw new PaypalException("In setExpressCheckout: Response is not success");
    }

    /**
     * @param PaypalPayment $paypalPayment
     * @param $payerID
     * @throws PaypalException
     * @return array
     */
    protected function doExpressCheckout(PaypalPayment $paypalPayment, $payerID)
    {
        try{
            /*
             * The total cost of the transaction to the buyer.
             *
             * If shipping cost (not applicable to digital goods) and tax
             * charges are known, include them in this value.
             *
             * If not, this value should be the current sub-total of the order.
             *
             * If the transaction includes one or more one-time purchases,
             * this field must be equal to the sum of the purchases.
             *
             * Set this field to 0 if the transaction does not include a one-time
             * purchase such as when you set up a billing
             * agreement for a recurring payment that is not immediately charged.
             *
             * When the field is set to 0, purchase-specific fields are ignored.
             *
             * For digital goods, the following must be true:
             * total cost > 0
             * total cost <= total cost passed in the call to SetExpressCheckout
            */

            /*
             *  Unique PayPal buyer account identification number as returned in the GetExpressCheckoutDetails response
            */
            $payerId = urlencode($payerID);
            $paymentAction = urlencode( Config::get('paypal.payment.action'));

            /*
             * The total cost of the transaction to the buyer.
             * If shipping cost (not applicable to digital goods) and tax charges are known, include them in this value.
             * If not, this value should be the current sub-total of the order. If the transaction includes one or
             * more one-time purchases, this field must be equal to the sum of the purchases.
             * Set this field to 0 if the transaction does not include a one-time purchase such as
             * when you set up a billing agreement for a recurring payment that is not immediately charged.
             * When the field is set to 0, purchase-specific fields are ignored.
            */
            $orderTotal = new BasicAmountType();
            $orderTotal->currencyID = $paypalPayment->grossAmount->currency;
            $orderTotal->value = $paypalPayment->grossAmount->value;

            $paymentDetails= new PaymentDetailsType();
            $paymentDetails->OrderTotal = $orderTotal;

            // Important specify this @todo
    //        $paymentDetails->NotifyURL = URL::route('paypal.done');

            $DoECRequestDetails = new DoExpressCheckoutPaymentRequestDetailsType();
            $DoECRequestDetails->PayerID = $payerId;
            $DoECRequestDetails->Token = $paypalPayment->token;
            $DoECRequestDetails->PaymentAction = $paymentAction;
            $DoECRequestDetails->PaymentDetails[0] = $paymentDetails;

            $DoECRequest = new DoExpressCheckoutPaymentRequestType();
            $DoECRequest->DoExpressCheckoutPaymentRequestDetails = $DoECRequestDetails;

            $DoECReq = new DoExpressCheckoutPaymentReq();
            $DoECReq->DoExpressCheckoutPaymentRequest = $DoECRequest;

            $paypalService = new PayPalAPIInterfaceServiceService(Config::get('paypal.settings'));

            // Any exception will be caught be laravel exception handling system
            $DoECResponse = $paypalService->DoExpressCheckoutPayment($DoECReq);

        }catch(Exception $e) {

            throw new PaypalException("In doExpressCheckout: {$e->getMessage()}");
        }

        if(isset($DoECResponse))
        {
            if(isset($DoECResponse->DoExpressCheckoutPaymentResponseDetails->PaymentInfo))
            {
                return array(

                    'transactionID' => $DoECResponse->DoExpressCheckoutPaymentResponseDetails->PaymentInfo[0]->TransactionID,

                    'grossAmount' => $DoECResponse->DoExpressCheckoutPaymentResponseDetails->PaymentInfo[0]->GrossAmount,

                    'feeAmount' => $DoECResponse->DoExpressCheckoutPaymentResponseDetails->PaymentInfo[0]->FeeAmount,

                    'taxAmount' => $DoECResponse->DoExpressCheckoutPaymentResponseDetails->PaymentInfo[0]->TaxAmount

                );
            }
        }

        throw new PaypalException("In doExpressCheckout: Response is not success");
    }

    /**
     * @param GetExpressCheckoutDetailsResponseType $response
     * @return array
     */
    protected function extractExpressCheckoutRequiredInfo( GetExpressCheckoutDetailsResponseType $response )
    {
        try{
            $responseDetails = $response->GetExpressCheckoutDetailsResponseDetails;

            $payerInfo = $responseDetails->PayerInfo;
            $payment = $responseDetails->PaymentDetails[0];

            $payer['id'] = $payerInfo->PayerID;
            $payer['status'] = $payerInfo->PayerStatus;

            $contact['email'] = $payerInfo->Payer;
            $contact['fullName'] = $payment->ShipToAddress->Name;
            $contact['phone'] = $payment->ShipToAddress->Phone;

            $location['street'] = $payment->ShipToAddress->Street1;
            $location['country'] = $payment->ShipToAddress->Country;
            $location['countryName'] = $payment->ShipToAddress->CountryName;

            $order['total'] = $payment->OrderTotal->value;
            $order['currency'] = $payment->OrderTotal->currencyID;

        }catch(Exception $e) {

            throw new PaypalException("In extractExpressCheckoutRequiredInfo: {$e->getMessage()}");
        }

        return compact('payer', 'contact', 'location', 'order');
    }

    /**
     * @param $QAR
     * @throws PaypalException
     * @return float
     */
    protected function convertFromQARToUSD($QAR)
    {
        if(! $rate = $this->conversionRate('QAR', 'USD'))
        {
            throw new PaypalException('Something wrong happened when trying to convert from QAR to USD');
        }

        return round($QAR * $rate, 2);
    }

    /**
     * @param $from
     * @param $to
     * @return mixed
     */
    protected function conversionRate($from, $to)
    {
        try{
            $object = json_decode(file_get_contents('http://rate-exchange.appspot.com/currency?from='.$from.'&to='.$to));

            return $object->rate;
        }catch(Exception $e){

            // Return default rate
            return 0.27463500000000002;
        }

    }
}