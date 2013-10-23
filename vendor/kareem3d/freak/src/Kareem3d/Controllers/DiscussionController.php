<?php namespace Kareem3d\Controllers;

use Illuminate\Support\Facades\Input;
use Kareem3d\Freak\DBRepositories\Discussion;

class DiscussionController extends FreakController {

    /**
     * @var Discussion
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
    public function postIndex()
    {
        $discussion = $this->discussions->newInstance(Input::get('Discussion'));

        if(! $discussion->isValid())
        {
            $this->addModelErrors($discussion);
        }
        else
        {
            // Add this discussion to the control panel
            $this->getControlPanel()->discussions()->save($discussion);

            // The current authenticated user created it
            $this->getAuthUser()->creates($discussion);
        }

        return $this->redirectBack('Message added.');
    }

}