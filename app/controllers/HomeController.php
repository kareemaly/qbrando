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
    public function getIndex()
    {
        $products = $this->productsAlgorithm->paginate( 12 );

        $productsTitle = 'Latest products';

        return View::make('pages.home', compact('products', 'productsTitle'));
    }

}