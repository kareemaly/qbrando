<?php

use Illuminate\Support\Facades\App;

App::missing(function()
{
    echo 'You don\'t have a control panel attached to you. <a href="'.freakUrl('logout').'">logout</a>';
    exit();
});