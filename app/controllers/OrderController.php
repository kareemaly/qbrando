<?php

use Kareem3d\Ecommerce\Order;
use Kareem3d\Membership\UserInfo;

class OrderController extends \BaseController {

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
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function store()
	{
        $order = $this->orders->create(Input::get('order'));

        $order->setUserInfo( Input::get('UserInfo') );
	}

}