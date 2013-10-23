<?php namespace Kareem3d\Controllers;

use Asset;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Illuminate\Support\MessageBag;
use Kareem3d\Freak\DBRepositories\User;

class ContactsController extends FreakController {

    /**
     * @var User
     */
    protected $users;

    /**
     * @param User $users
     */
    public function __construct( User $users )
    {
        $this->users    = $users;
    }

    /**
     * Get Inbox messages...
     */
    public function getIndex()
    {
        Asset::addPlugin('contact');

        $groups = array();

        foreach ($this->getControlPanel()->getAcceptedUsers() as $user)
        {
            $character = substr(strtolower($user->name), 0, 1);

            if( !isset($groups[$character]) )

                $groups[ $character ] = array( $user );

            else

                $groups[ $character ][] = $user;
        }

        return View::make('freak::contacts.index', compact('groups'));
    }
}