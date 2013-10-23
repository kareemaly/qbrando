<?php namespace Kareem3d\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Illuminate\Support\MessageBag;
use Kareem3d\Freak\DBRepositories\Message;
use Kareem3d\Freak\DBRepositories\User;

class MailController extends FreakController {

    /**
     * @var \Kareem3d\Freak\DBRepositories\Message
     */
    protected $messages;

    /**
     * @var User
     */
    protected $users;

    /**
     * @param Message $messages
     * @param User $users
     */
    public function __construct( Message $messages, User $users )
    {
        $this->messages = $messages;
        $this->users    = $users;
    }

    /**
     * Get Inbox messages...
     */
    public function getInbox()
    {
        $inbox = $this->messages->inbox($this->getAuthUser());
        $sent  = $this->messages->sent($this->getAuthUser());
        $trash = $this->messages->trash($this->getAuthUser());
        $users = $this->getControlPanel()->getAcceptedUsers( $this->getAuthUser() );

        $this->getAuthUser()->seenRecipients($this->messages->getClass());

        return View::make('freak::messages.index', compact('inbox', 'sent', 'users', 'trash'));
    }

    /**
     * @param $id
     */
    public function getShow( $id )
    {
        $message = $this->messages->find($id);

        $this->getAuthUser()->seenRecipient($message);

        return View::make('freak::messages.detail', compact('message'));
    }

    /**
     * Creating email
     */
    public function postCreate()
    {
        if($toUser = $this->users->find(Input::get('Message.to_id')))
        {
            $message = $this->messages->create(array(
                'subject' => Input::get('Message.subject'),
                'body'    => Input::get('Message.body')
            ));

            $message->createdBy($this->getAuthUser());
            $message->receivedBy($toUser);

            return $this->redirectBack('Mail sent to ' . $toUser->name);
        }

        return Redirect::back()->with('errors', 'Something went wrong while trying to senting mail.. try again');
    }

    /**
     * @param $id
     */
    public function getTrash( $id )
    {
        $this->messages->find($id)->moveToTrash($this->getAuthUser());

        return Redirect::back()->with('success', 'Message moved to trash successfully.');
    }

    /**
     * @param $id
     */
    public function getDelete( $id )
    {
        $this->messages->find($id)->moveToDeleted($this->getAuthUser());

        return Redirect::back()->with('success', 'Message deleted successfully.');
    }
}