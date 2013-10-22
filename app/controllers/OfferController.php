<?php

class OfferController extends \BaseController {

    /**
     * @var Offer
     */
    protected $offers;

    /**
     * @param Offer $offers
     */
    public function __construct( Offer $offers )
    {
        $this->offers = $offers;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        return $this->offers->all();
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        return $this->offers->find( $id );
	}
}