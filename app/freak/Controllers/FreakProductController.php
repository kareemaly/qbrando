<?php

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Kareem3d\Controllers\FreakController;

class FreakProductController extends FreakController {

    /**
     * @var Product
     */
    protected $products;

    /**
     * @var Category
     */
    protected $categories;

    /**
     * @var Color
     */
    protected $colors;

    /**
     * @param Product $products
     * @param Category $categories
     * @param Color $colors
     */
    public function __construct( Product $products, Category $categories, Color $colors )
    {
        $this->products = $products;

        $this->categories = $categories;

        $this->colors = $colors;

        $this->usePackages( 'Image' );

        $this->setExtra(array(
            'images-group-name' => 'Product.Gallery',
            'images-type'       => 'gallery',
            'image-group-name'  => 'Product.Main',
            'image-type'        => 'main',
        ));
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getIndex()
    {
        $products = $this->products->get();

        return View::make('panel::products.data', compact('products'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function getShow($id)
    {
        $product = $this->products->find( $id );

        $this->setPackagesData($product);

        return View::make('panel::products.detail', compact('product', 'id'));
    }

    /**
     * Show the add for creating a new resource.
     *
     * @return Response
     */
    public function getCreate()
    {
        $product = $this->products;

        $this->setPackagesData($product);

        $categories = $this->categories->all();

        $colors = $this->colors->all();

        return View::make('panel::products.add', compact('product', 'categories', 'colors'));
    }

    /**
     * Show the add for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function getEdit($id)
    {
        $product = $this->products->find( $id );

        $this->setPackagesData($product);

        return $this->getCreate()->with('product', $product);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function postCreate()
    {
        // Find or get new instance of the product
        $product = $this->products->findOrNew(Input::get('insert_id'))->fill(Input::get('Product'));

        $this->setImageSEO($product);

        return $this->jsonValidateResponse($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function postEdit($id)
    {
        $product = $this->products->find($id)->fill(Input::get('Product'));

        $this->setImageSEO( $product );

        return $this->jsonValidateResponse( $product );
    }

    /**
     * @param Product $product
     */
    protected function setImageSEO( Product $product )
    {
        $this->addExtra('image-title', $product->en('title'));
        $this->addExtra('image-alt', $product->en('title'));
        $this->addExtra('images-title', $product->en('title'));
        $this->addExtra('images-alt'  , $product->en('title'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function getDelete($id)
    {
        $this->products->find($id)->delete();

        return $this->redirectBack('Product deleted successfully.');
    }

    /**
     * @internal param \Product $product
     */
    public function postFacebook($id)
    {
        $product = $this->products->findOrFail($id);

        if(! $facebookTitle = Input::get('facebook_title'))
        {
            $facebookTitle = $product->title . PHP_EOL;

            if($product->hasOfferPrice())
            {
                $facebookTitle .= 'Special Offer <<<<<'.$product->actualPrice.' QAR>>>>>>';
            }

            else
            {
                $facebookTitle .= 'Price ' .$product->actualPrice . ' QAR';
            }
        }

        $fb = new Facebook(Config::get('facebook.config'));

        $params = array(
            "access_token" => Config::get('facebook.access_token'),
            "message" => $facebookTitle,
            "source" => $product->getImage('main')->getLargest()->url,
        );

        try {
            $fb->api('/'.Config::get('facebook.page_id').'/feed', 'POST', $params);

            return Redirect::back()->with('success', 'Product has been posted to facebook successfully.');
        } catch(Exception $e) {

            dd('Eb3tly elmsg de yhoby: ' . $e->getMessage());
        }
    }
}