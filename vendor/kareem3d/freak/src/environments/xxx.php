<?php

use Illuminate\Support\Facades\View;
use Illuminate\Support\MessageBag;

// Share success message across all views
View::share('success', new MessageBag((array) Session::get('success', array())));
