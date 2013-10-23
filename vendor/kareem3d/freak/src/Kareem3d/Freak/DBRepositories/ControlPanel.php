<?php namespace Kareem3d\Freak\DBRepositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

use Kareem3d\Eloquent\Model;
use Kareem3d\Freak\DBRepositories\Message;

class ControlPanel extends Model {

    const COOKIE_NAME = 'CXIOJ#Kq2ewd';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'control_panels';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array('password');

    /**
     * The attributes that can't be mass assigned
     *
     * @var array
     */
    protected $guarded = array('id');

    /**
     * Whether or not to softDelete
     *
     * @var bool
     */
    protected $softDelete = false;

    /**
     * Validations rules
     *
     * @var array
     */
    protected $rules = array(
        'app_id' => 'required',
        'name' => 'required',
        'password' => 'required',
    );

    /**
     * @return mixed|void
     */
    public function beforeValidate()
    {
        // If first time to create this control panel then generate app id.
        if(! $this->exists)
        {
            $this->generateAppId();
        }
    }

    /**
     * @param $password
     * @return ControlPanel
     */
    public static function getByPassword( $password )
    {
        foreach(static::all() as $controlPanel)
        {
            if($controlPanel->password == $password)

                return $controlPanel;
        }
    }

    /**
     * Set the application password
     *
     * @param  string $password
     * @return void
     */
    public function setPasswordAttribute( $password )
    {
        $this->attributes['password'] = $this->encrypt($password);
    }

    /**
     * Get application password.
     *
     * @param $password
     * @return string
     */
    public function getPasswordAttribute( $password )
    {
        return $this->decrypt($password);
    }

    /**
     * Generate the application id
     *
     * @return void
     */
    public function generateAppId()
    {
        $this->app_id = Str::random( 6 );
    }

    /**
     * @param ControlPanel $controlPanel
     */
    public static function setCurrent( ControlPanel $controlPanel )
    {
        Cookie::forever(self::COOKIE_NAME, static::encrypt($controlPanel->id));
    }

    /**
     * @param User $user
     * @return ControlPanel|null
     */
    public static function getCurrent( User $user )
    {
        if($cookie = Cookie::get(self::COOKIE_NAME, false))
        {
            $id = static::decrypt($cookie);

            // Get control panel attached to this user and has id equal to the cookie
            return $user->getControlPanelById($id);
        }

        return static::getDefault( $user );
    }

    /**
     * Get first control panel attached to this user.
     *
     * @param User $user
     * @return ControlPanel|null
     */
    public static function getDefault( User $user )
    {
        return $user->controlPanels->first();
    }

    /**
     * Message all users attached to this control panel
     *
     * @param \Kareem3d\Freak\DBRepositories\Message $message
     * @param User $except
     */
    public function messageAllUsers( Message $message, User $except = null )
    {
        foreach($this->users as $user)
        {
            if($except && !$except->same($user))
            {
                $message->receivedBy($user);
            }
        }
    }

    /**
     * Add new user to this application.
     *
     * @param \Kareem3d\Freak\DBRepositories\User $user
     * @param bool $accepted
     * @return void
     */
    public function attachUser( User $user , $accepted = false )
    {
        if(! $this->hasUser( $user ))

            $this->users()->attach( $user );

        if($accepted)

            $this->acceptUser( $user );
    }

    /**
     * @param User $user
     * @return int
     */
    public function unacceptUser( User $user )
    {
        return $this->getUserPivotQuery($user)->update(array(
            'user_control_panel.accepted' => false
        ));
    }

    /**
     * @param User $user
     * @return int
     */
    public function acceptUser( User $user )
    {
        return $this->getUserPivotQuery($user)->update(array(
            'user_control_panel.accepted' => true
        ));
    }

    /**
     * @param User $user
     * @return bool
     */
    public function hasUser( User $user )
    {
        return $this->getUserPivotQuery($user)->count() > 0;
    }

    /**
     * @param User $user
     * @return Builder
     */
    public function getUserPivotQuery( User $user )
    {
        return $this->users()->where('user_control_panel.user_id', $user->id);
    }

    /**
     * @param User $user
     */
    public function detachUser( User $user )
    {
        $this->users()->detach($user);
    }

    /**
     * @param User $except
     * @return Collection
     */
    public function getAcceptedUsers( User $except = null )
    {
        $query = $this->users();

        if($except)
        {
            $query->where('user_control_panel.user_id', '!=', $except->id);
        }

        return $query->where('user_control_panel.accepted', true)->get();
    }

    /**
     * Establish a one-to-many relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany( User::getClass(), 'user_control_panel' )->withPivot('accepted');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function discussions()
    {
        return $this->hasMany( Discussion::getClass() );
    }
}

