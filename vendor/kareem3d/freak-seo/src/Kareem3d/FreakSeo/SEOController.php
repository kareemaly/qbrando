<?php namespace Kareem3d\FreakSeo;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Kareem3d\Controllers\FreakController;
use Kareem3d\Marketing\SEO;

class SEOController extends FreakController {

    /**
     * @var SEO
     */
    protected $seo;

    /**
     * @var SEO
     * @var User
     */
    public function __construct( SEO $seo )
    {
        $this->seo = $seo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getIndex()
    {
        $seo = $this->seo->get();

        return View::make('freak-seo::seo.data', compact('seo'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function getShow($id)
    {
        $seo = $this->seo->find( $id );

        return View::make('freak-seo::seo.detail', compact('id', 'seo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getCreate()
    {
        $seo = $this->seo;

        return View::make('freak-seo::seo.add', compact('seo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function getEdit($id)
    {
        $seo = $this->seo->findOrFail( $id );

        return View::make('freak-seo::seo.add', compact('seo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function postCreate()
    {
        $inputs = Input::get('SEO');

        if(strpos($inputs['url'], 'http') === false)

            $inputs['url'] = 'http://' . $inputs['url'];

        $seo = $this->seo->newInstance($inputs);

        return $this->jsonValidateResponse($seo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function postEdit($id)
    {
        $inputs = Input::get('SEO');

        if(strpos($inputs['url'], 'http') === false)

            $inputs['url'] = 'http://' . $inputs['url'];

        $seo = $this->seo->find($id)->fill($inputs);

        return $this->jsonValidateResponse($seo);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function getDelete($id)
    {
        $this->seo->find($id)->delete();

        return Redirect::back()->with('success', 'Deleted successfully.');
    }
}