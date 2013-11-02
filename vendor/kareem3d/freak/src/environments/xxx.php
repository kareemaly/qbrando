<?php

use Illuminate\Support\Facades\View;
use Illuminate\Support\MessageBag;

class Asset extends \Asset\Asset{}

// Share success message across all views
View::share('success', new MessageBag((array) Session::get('success', array())));
