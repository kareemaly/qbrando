<?php

use Kareem3d\Ecommerce\Order;

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
     * @param Product $products
     * @param Order $orders
     * @param UserInfo $userInfo
     */
    public function __construct(Product $products, Order $orders, UserInfo $userInfo)
    {
        $this->orders = $orders;
        $this->userInfo = $userInfo;
        $this->products = $products;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        $this->layout->template->addPart('body', array('checkout'));

        $this->layout->template->addPart('head', array('facebook_conversation_pixel'));
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
        return $this->index();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function placeOrder()
    {
        // Create and validate user information
        $userInfo = $this->userInfo->newInstance(Input::get('UserInfo'));

        if($userInfo->isValid())
        {
            $userInfo->save();

            // New order with user info..
            $order = $this->orders->newInstance();

            // Set order user information
            $order->setUserInfo( $userInfo );

            // Add cart products to order
            foreach(Cart::contents() as $item)
            {
                $product = $this->products->findOrFail($item->id);

                $order->addProduct( $product, $item->quantity );
            }


            // Order created successfully, now clear cart
            Cart::destroy();

            return Redirect::route('message-to-user')

                ->with('title', 'Thanks '. ucfirst($userInfo->first_name) .'! We will contact you soon.')

                ->with('message', 'Order has been placed successfully. Thank you for choosing QBrando <strong>online shop for luxury in Qatar</strong><br />
                <a href='.URL::route('home').'>Go back home</a>');
        }

        else
        {
            return Redirect::back()->withErrors( $userInfo->getValidatorMessages() );
        }
    }

}