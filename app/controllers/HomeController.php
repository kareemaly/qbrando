<?php

class HomeController extends BaseController {

    /**
     * @var ProductAlgorithm
     */
    protected $productsAlgorithm;

    /**
     * @param ProductAlgorithm $productsAlgorithm
     */
    public function __construct( ProductAlgorithm $productsAlgorithm )
    {
        $this->productsAlgorithm = $productsAlgorithm;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        $products = $this->productsAlgorithm->orderByDate()->paginate( 12 );

        $productsTitle = 'Latest sunglasses';

        $this->layout->template->addPart('body', array('products'), compact('products', 'productsTitle'));

        $this->layout->template->findPart('lower_header')->addChild('flash_offers');

        $this->layout->template->findPart('footer')->addChild('bottom_cart_notifier');
    }

    /**
     * @return mixed
     */
    public function message()
    {
        $messageTitle = Session::get('title');

        $messageBody = Session::get('message');

        $this->layout->template->addPart('body', array('message'), compact('messageTitle', 'messageBody'));

        if(! $messageTitle) return Redirect::route('home');
    }

}