<?php namespace Kareem3d\Controllers;

use Helper\Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class LoginController extends FreakController {

    /**
     * @return mixed
     */
    public function getIndex()
    {
        return View::make('freak::login.index');
    }

    /**
     * @return mixed
     */
    public function postIndex()
    {
        // Attempt to login with user inputs
        if(Auth::attempt($this->getUserInputs(), Input::has('Login.remember')))
        {
            return freakRedirect('home');
        }

        return Redirect::back()->withInput()->withErrors('Email and/or password are incorrect.');
    }

    /**
     * @return mixed
     */
    protected function getUserInputs()
    {
        return Helper::instance()->arrayGetKeys(Input::get('Login', array()), array('email', 'password'));
    }
}