<?php namespace Kareem3d\Controllers;

class FreakElementController extends FreakController {

    public function getIndex()
    {
        return View::make('freak::elements.data');
    }

    public function getCreate()
    {
        return View::make('freak::elements.add');
    }

    public function getShow()
    {
        return View::make('freak::elements.detail');
    }
}