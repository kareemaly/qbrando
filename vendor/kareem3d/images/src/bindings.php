<?php

use Kareem3d\Images\Group;
use Kareem3d\Images\ImageFacade;
use Kareem3d\Images\ImageManager;
use PathManager\Path;
use Symfony\Component\HttpFoundation\File\UploadedFile;

// Automatically Inject ImageManager
App::bind('\Kareem3d\Images\ImageManager', function($app, Group $group)
{
    return new ImageManager($group, Path::makeFromBase(), App::make('\Kareem3d\Images\Version'));
});

App::bind('\Kareem3d\Images\ImageFacade', function($app, UploadedFile $file)
{
    return new ImageFacade($file, App::make('\Kareem3d\Images\Group'));
});