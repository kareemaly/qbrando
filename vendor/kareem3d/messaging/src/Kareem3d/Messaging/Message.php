<?php namespace Kareem3d\Messaging;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Kareem3d\Eloquent\Model;
use Kareem3d\Membership\User;

class Message extends Model {

    const ACTIVE = 0;
    const TRASH = 1;
    const DELETED = 2;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'messages';

    /**
     * The attributes that can't be mass assigned
     *
     * @var array
     */
    protected $guarded = array('id');

    /**
     * Validations rules
     *
     * @var array
     */
    protected $rules = array(
        'type' => 'required|in:0,1,2'
    );

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param User $user
     */
    public function createdBy( User $user )
    {
        $user->creates($this, array('type' => static::ACTIVE));
    }

    /**
     * @param User $user
     */
    public function receivedBy( User $user )
    {
        $user->receives($this, array('type' => static::ACTIVE));
    }

    /**
     * @return User
     */
    public function getFromUser()
    {
        return App::make('Kareem3d\Membership\User')->getByCreation($this)->first();
    }

    /**
     * @return User
     */
    public function getToUser()
    {
        return App::make('Kareem3d\Membership\User')->getByRecipient($this)->first();
    }

    /**
     * @param User $user
     * @return \Illuminate\Support\Collection
     */
    public static function inbox( User $user )
    {
        return $user->getRecipients(static::getClass(), array(
            'type' => static::ACTIVE
        ));
    }

    /**
     * @param User $user
     * @return \Illuminate\Support\Collection
     */
    public static function sent( User $user )
    {
        return $user->getCreations(static::getClass(), array(
            'type' => static::ACTIVE
        ));
    }

    /**
     * @param User $user
     * @return Collection
     */
    public static function trash( User $user )
    {
        return $user->getCreations(static::getClass(), array(
            'type' => static::TRASH
        ))->merge($user->getRecipients(static::getClass(), array(
            'type' => static::TRASH
        )));
    }

    /**
     * @param User $user
     */
    public function moveToTrash( User $user )
    {
        $this->moveTo($user, static::TRASH);
    }

    /**
     * @param User $user
     */
    public function moveToDeleted( User $user )
    {
        $this->moveTo($user, static::DELETED);
    }

    /**
     * @param User $user
     * @param $type
     */
    public function moveTo( User $user, $type )
    {
        if($user->hasReceived($this))
        {
            $user->setRecipientExtra($this, compact('type'));
        }
        elseif($user->hasCreated($this))
        {
            $user->setCreationExtra($this, compact('type'));
        }
    }
}