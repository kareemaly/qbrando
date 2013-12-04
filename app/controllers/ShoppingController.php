<?php 

class ShoppingController extends BaseController {

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
     *
     */
    public function index()
    {
        $products = $this->productsAlgorithm->available()->paginate(self::PER_PAGE);

        $productsTitle = 'Related products';

        $brightTitle = true;

        $this->layout->template->addPart('body', array('cart', 'products'), compact('products', 'productsTitle', 'brightTitle'));
    }

}