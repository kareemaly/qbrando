<?php

use Kareem3d\Ecommerce\Order;
use Kareem3d\Membership\UserInfo;

class CheckoutController extends BaseController {

    /**
     * @var Order
     */
    protected $orders;

    /**
     * @var UserInfo
     */
    protected $userInfos;

    /**
     * @param Order $orders
     * @param UserInfo $userInfos
     */
    public function __construct(Order $orders, UserInfo $userInfos)
    {
        $this->orders = $orders;
        $this->userInfos = $userInfos;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        $this->layout->template->addPart('body', array('checkout'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function createOrder()
    {
        $order = $this->orders->create(Input::get('order'));

        $order->setUserInfo( Input::get('UserInfo') );
    }

}