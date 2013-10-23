<?php

use Illuminate\Support\Facades\App;
use Kareem3d\Freak;
use Kareem3d\Freak\ClientRepository;
use Kareem3d\Freak\Menu\Menu;

// Get all registered clients
$clients = ClientRepository::getRegistered();

$packages = Freak\PackageRepository::getRegistered();

// Get authenticated user and make him online
$authUser = freakEnvironment()->authUser();

// Create menu with defaults
$menu = with(new Menu())->useDefaults();

// Once freak is created registering clients will not be considered, instead you can use the freak instance
// to add client to it.
$freak = Freak::factory($authUser, $clients, $packages, $menu);

// Use defaults and run the freak application
$freak->useDefaults();
$freak->run();


// Register it in the IOC container
App::instance('Kareem3d\Freak', $freak);


require __DIR__ . '/filters.php';
require __DIR__ . '/routes.php';
require __DIR__ . '/composers.php';
