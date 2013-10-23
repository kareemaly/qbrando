<?php namespace Kareem3d\Controllers;

use Helper\Helper;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Kareem3d\Freak\DBRepositories\ControlPanel;
use Kareem3d\Freak\DBRepositories\Message;
use Kareem3d\Freak\DBRepositories\User;
use Kareem3d\Images\Image;
use Kareem3d\Images\Version;
use Kareem3d\Membership\UserInfo;

class RegisterController extends FreakController {

    /**
     * @var \Kareem3d\Freak\DBRepositories\User
     */
    protected $users;

    /**
     * @var \Kareem3d\Membership\UserInfo
     */
    protected $userInfos;

    /**
     * @var Message
     */
    protected $messages;

    /**
     * @var \Kareem3d\Freak\DBRepositories\ControlPanel
     */
    protected $controlPanels;

    /**
     * @var \Kareem3d\Images\Image
     */
    protected $images;

    /**
     * @var \Kareem3d\Images\Version
     */
    protected $versions;

    /**
     * @param \Kareem3d\Freak\DBRepositories\User $users
     * @param \Kareem3d\Membership\UserInfo $userInfos
     * @param \Kareem3d\Freak\DBRepositories\Message $messages
     * @param \Kareem3d\Freak\DBRepositories\ControlPanel $controlPanels
     * @param \Kareem3d\Images\Image $images
     * @param \Kareem3d\Images\Version $versions
     */
    public function __construct( User $users, UserInfo $userInfos, Message $messages, ControlPanel $controlPanels, Image $images, Version $versions )
    {
        $this->users = $users;
        $this->userInfos = $userInfos;
        $this->messages = $messages;
        $this->controlPanels = $controlPanels;
        $this->images = $images;
        $this->versions = $versions;
    }

    /**
     * @return mixed
     */
    public function getIndex()
    {
        return View::make('login.index');
    }

    /**
     * @return mixed
     */
    public function postIndex()
    {
        if($user = $this->registerUser())
        {
            $this->attachToControlPanel( $user );
        }

        return $this->redirectBack('You have registered successfully.<br /> An admin from you application has to <b>accept</b> you before you can login.');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model|\Kareem3d\Membership\User|null|static
     */
    protected function registerUser()
    {
        $userInputs = $this->getUserInputs();

        // If we have this user in our database then check if he entered the correct password
        if($user = $this->users->getByEmail($userInputs['email']))
        {
            // If user has password and it's not the correct password
            if($user->hasPassword() && !$user->checkPassword($userInputs['password']))
            {
                $this->addErrors('This email already exists but the password is incorrect');
            }

            // Fill user with inputs
            $user->fill($userInputs);

            // Escape this validation rule: email
            $user->escapeRule('email');
        }
        else
        {
            $user = $this->users->newInstance($userInputs);
        }

        // If user is not valid
        if($user->isValid())
        {
            $user->access = $user::LOW_ACCESS;

            $user->save();

            // Set default profile image
            $user->replaceImage( $this->getDefaultProfileImage(), 'profile' );

            // Create user info inputs
            $userInfo = $this->userInfos->newInstance($this->getUserInfoInputs());

            // If user is valid
            $user->addInfo($userInfo);

            return $user;
        }

        else
        {
            $this->addModelErrors($user);
        }
    }

    /**
     * @return Image
     */
    protected function getDefaultProfileImage()
    {
        $image = $this->images->create(array('title' => 'Profile default image'));

        $image->add($this->versions->generate('http://s3.amazonaws.com/37assets/svn/765-default-avatar.png'));

        return $image;
    }

    /**
     * @param User $user
     */
    protected function attachToControlPanel( User $user )
    {
        $controlPanel = $this->controlPanels->getByPassword( $this->getControlPanelPassword() );

        if(! $controlPanel)
        {
            $this->addErrors('The application password is incorrect.');
        }

        // If entered password is correct and control panel is found
        else
        {
            // Check if user already registered to this control panel
            if($user->hasRegisteredControlPanel( $controlPanel ))
            {
                // If he has access on it then just tell him to try to login in
                if($user->hasAccessOn( $controlPanel ))
                {
                    $this->addErrors('We seem to have you in our database and you have access on this control panel! Try to login.');
                }

                // He has registered for control panel but doesn't have access on it so that means he hasn't been accepted yet.
                else
                {
                    $this->addErrors('You already registered for this control panel but haven\'t been accepted yet by any admin. Try to contact them.');
                }
            }

            else
            {
                $user->registerControlPanel( $controlPanel );

                // If control panel already has some users in it then message them to see whether
                // they will accept him or not...
                if($controlPanel->getAcceptedUsers()->count() > 0)
                {
                    $this->sendMessageToAll( $user, $controlPanel );
                }

                // This is the first admin registering in the control panel then just accept him..
                else
                {
                    $user->access = $user::HIGH_ACCESS;
                    $user->save();

                    $controlPanel->acceptUser($user);
                }
            }
        }
    }

    /**
     * @param User $user
     * @param ControlPanel $controlPanel
     */
    protected function sendMessageToAll( User $user, ControlPanel $controlPanel )
    {
        $acceptLink = freakUrl('permissions/accept-user/'. $user->id);
        $refuseLink = freakUrl('permissions/refuse-user/'. $user->id);

        $message = $this->messages->create(array(
            'subject' => 'A new admin wish to register for this application control panel',
            'body' => $user->getInfo( 'name' )." has registered for this application control panel, but he/she needs you to accept him/her to be able to login to the controlpanel and start managing ".$controlPanel->name.".<br /><br />".
                "<a href='".$acceptLink."' style='color:#5ad623'>Click here if you know him/her (Accept)</a> | <a href='".$refuseLink."' style='color=#900'>Click here if you don't know him/her (Refuse)</a>"
        ));

        // User creates this message
        $message->createdBy($user);

        // Message all users in the control panel
        $controlPanel->messageAllUsers($message, $user);
    }

    /**
     * @return mixed
     */
    protected function getUserInputs()
    {
        return Helper::instance()->arrayGetKeys(Input::get('Register'), array('email', 'password'));
    }

    /**
     * @return mixed
     */
    protected function getUserInfoInputs()
    {
        return array('name' => Input::get('Register.name'));
    }

    /**
     * @return mixed
     */
    protected function getControlPanelPassword()
    {
        return Input::get('ControlPanel.password');
    }
}