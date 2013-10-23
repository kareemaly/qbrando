<?php namespace Kareem3d\Controllers;

use Asset\Asset;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Kareem3d\Freak;
use Kareem3d\Freak\DBRepositories\Message;
use Kareem3d\Freak\DBRepositories\User;

class PermissionsController extends FreakController {

    /**
     * @var \Kareem3d\Freak
     */
    protected $freak;

    /**
     * @var \Kareem3d\Freak\DBRepositories\User
     */
    protected $users;

    /**
     * @var \Kareem3d\Freak\DBRepositories\Message
     */
    protected $messages;

    /**
     * @param Freak $freak
     * @param \Kareem3d\Freak\DBRepositories\User $users
     * @param \Kareem3d\Freak\DBRepositories\Message $messages
     */
    public function __construct(Freak $freak, User $users, Message $messages)
    {
        $this->freak = $freak;
        $this->users = $users;
        $this->messages = $messages;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getUser( $id )
    {
        Asset::addPlugin('ibutton');

        $elements = $this->freak->getClientsElements();

        $user = $this->getUserById($id);

        return View::make('freak::permissions.index', compact('elements', 'user'));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getAcceptUser( $id )
    {
        $user = $this->getUserById($id);

        $this->getControlPanel()->acceptUser( $user );

        // Remove any message from this user [Message to accept or refuse him]
        $messages = $user->getCreations($this->messages->getClass());

        foreach($messages as $message) $message->delete();

        return Redirect::action(get_called_class() . '@getUser', array($id));
    }

    /**
     * @param $id
     */
    public function postUser( $id )
    {
        $user = $this->getUserById($id);

        $user->access = Input::get('Permission.access');

        $user->save();

        foreach(Input::get('Permission.Elements', array()) as $element)
        {
            $user->controlElement( $this->freak()->findClientsElement($element) );
        }

        return Redirect::back()->with('success', 'Permissions updated successfully for ' . $user->name);
    }

    /**
     * @param $id
     * @return User
     */
    protected function getUserById( $id )
    {
        return $this->users->find($id);
    }

}