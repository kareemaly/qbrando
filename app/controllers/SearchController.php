<?php

use Kareem3d\Ecommerce\Category;

class SearchController extends BaseController
{
    /**
     * @var Kareem3d\Ecommerce\Category
     */
    protected $categories;

    /**
     * @var ProductAlgorithm
     */
    protected $productsAlgorithm;

    /**
     * @var Color
     */
    protected $colors;

    /**
     * @param Category $categories
     * @param ProductAlgorithm $productsAlgorithm
     * @param Color $colors
     */
    public function __construct( Category $categories, ProductAlgorithm $productsAlgorithm, Color $colors )
    {
        $this->categories = $categories;
        $this->productsAlgorithm = $productsAlgorithm;
        $this->colors = $colors;
    }

    /**
     *
     */
    public function all()
    {
        return Redirect::home();
        return $this->layout->nest('content', 'pages.search');
    }

    /**
     * Search by category, color and model name
     */
    public function products()
    {
        if ($category = $this->getCategory(Input::get('brand')))
        {
            $this->productsAlgorithm->byCategory($category);
        }

        if ($color = $this->getColor(Input::get('color')))
        {
            $this->productsAlgorithm->byColor($color);
        }

        if($model = Input::get('model'))
        {
            $this->productsAlgorithm->byModel($model);
        }

        $productsTitle = $this->getProductsTitle( $category, $color );

        $products = $this->productsAlgorithm->orderByDate()->paginate(12);

        $this->layout->template->addPart('body', array('products'), compact('products', 'productsTitle'));
    }

    /**
     * @param null $category
     * @param null $color
     * @return string
     */
    protected function getProductsTitle( $category = null, $color = null )
    {
        if($category && $color)
        {
            return "Showing {$category->title} {$color->tilte} sunglasses";
        }
        elseif($category)
        {
            return "Showing {$category->title} sunglasses";
        }
        elseif($color)
        {
            return "Showing {$color->title} sunglasses";
        }
    }

    /**
     * @param $categoryTitle
     * @return Category
     */
    protected function getCategory($categoryTitle)
    {
        return $this->categories->getByTitle($categoryTitle);
    }

    /**
     * @param $colorTitle
     * @return Color
     */
    protected function getColor($colorTitle)
    {
        return $this->colors->getByTitle($colorTitle);
    }
}