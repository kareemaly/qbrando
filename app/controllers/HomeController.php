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
    }

}