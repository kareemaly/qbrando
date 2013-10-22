<?php

use Kareem3d\Ecommerce\Category;

class CategoryController extends \BaseController {

    /**
     * @var Kareem3d\Ecommerce\Category
     */
    protected $categories;

    /**
     * @param Category $categories
     */
    public function __construct( Category $categories )
    {
        $this->categories = $categories;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        return $this->categories->all();
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        return $this->categories->findOrFail($id);
	}

}