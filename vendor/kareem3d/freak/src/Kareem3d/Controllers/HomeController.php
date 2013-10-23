<?php namespace Kareem3d\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Kareem3d\Freak\DBRepositories\ControlPanel;
use Kareem3d\Freak\DBRepositories\Discussion;
use Kareem3d\Freak\DBRepositories\User;

class HomeController extends FreakController {

    /**
     * @var \Kareem3d\Freak\DBRepositories\Discussion
     */
    protected $discussions;

    /**
     * @param Discussion $discussions
     */
    public function __construct( Discussion $discussions )
    {
        $this->discussions = $discussions;
    }

    /**
     * @return mixed
     */
    public function getIndex()
    {
        $discussions = $this->getControlPanel()->discussions()->take(10)->get();

        $users = $this->getControlPanel()->getAcceptedUsers();

        return View::make('freak::home.index', compact('discussions', 'users'));
    }
}