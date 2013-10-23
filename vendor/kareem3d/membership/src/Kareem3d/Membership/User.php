<?php namespace Kareem3d\Membership;

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Query\Builder;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Support\Collection;
use Kareem3d\Eloquent\Model;

abstract class User extends Model implements UserInterface, RemindableInterface {

    /**
     * Users types
     */
    const VISITOR = 0;
    const NORMAL = 1;
    const ADMINISTRATOR = 9;
    const DEVELOPER = 10;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array('password');

    /**
     * @var array
     */
    protected $guarded = array('id');

    /**
     * Validation rules
     *
     * @var array
     */
    protected $rules = array(
        'username' => 'min:6',
        'email'    => 'required|email|unique:users',
        'password' => 'regex:((?=.*\d)(?=.*[a-z]).{8,20})',
        'type'     => 'in:0,1,9,10',
    );

    /**
     * For factoryMuff package to be able to fill the post attributes.
     *
     * @var array
     */
    public static $factory = array(

        'username' => 'kareem3d',
        'email' => 'email',
        'password' => 'kareem123',

    );

    /**
     * @return array
     */
    public static function getTypes()
    {
        return array(
            static::VISITOR => 'visitor',
            static::NORMAL => 'normal',
            static::ADMINISTRATOR => 'administrator',
            static::DEVELOPER => 'developer'
        );
    }

    /**
     * @param $email
     * @return User
     */
    public static function getByEmail($email)
    {
        return static::where('email', $email)->first();
    }

    /**
     * Get administrator user. If not found get developer.
     *
     * @return User
     */
    public static function getDeveloper()
    {
        return static::where('type', self::DEVELOPER)->first();
    }

    /**
     * @return mixed
     */
    public static function getAdministrator()
    {
        return static::where('type', self::ADMINISTRATOR)->first();
    }

    /**
     * @return \Illuminate\Hashing\HasherInterface
     */
    public static function getHasher()
    {
        return new BcryptHasher();
    }

    /**
     * Make this user online
     */
    public function makeOnline()
    {
        $this->online_at = new \DateTime();

        $this->save();
    }

    /**
     * @return string
     */
    public function getOnlineAt()
    {
        return $this->online_at;
    }

    /**
     * Check if last time he has been online is less than 10 seconds or not
     *
     * @return bool
     */
    public function isOnline()
    {
        $now = strtotime('now');
        $lastOnline = strtotime($this->getOnlineAt());

        $seconds = $now - $lastOnline;

        return $seconds <= 20;
    }

    /**
     * @return void
     */
    public function beforeValidate()
    {
        // Clean from XSS attach
        $this->cleanXSS();
    }

    /**
     * @return bool
     */
    public function hasPassword()
    {
        return $this->password != null;
    }

    /**
     * @param string $checkPassword
     * @return bool
     */
    public function checkPassword( $checkPassword )
    {
        return !$this->password || $this->getHasher()->check($checkPassword, $this->password);
    }

    /**
     * @return void
     */
    public function makePassword()
    {
        $this->password = $this->getHasher()->make($this->password);
    }

    /**
     * @return void
     */
    public function beforeSave()
    {
        // If password is dirty which means it did change
        if($this->isDirty('password')) {

            $this->makePassword();
        }
    }

    /**
     * @param UserInfo $userInfo
     * @return \Kareem3d\Membership\UserInfo
     */
    public function setInfo( UserInfo $userInfo )
    {
        // First delete all user infos
        $this->infos()->delete();

        // Now add this user info to be the only info this user has
        return $this->addInfo($userInfo);
    }

    /**
     * @param UserInfo $userInfo
     * @return UserInfo|null
     */
    public function addInfo( UserInfo $userInfo )
    {
        if(! $duplicate = $userInfo->getDuplicateFor($this))
        {
            return $this->infos()->save($userInfo);
        }

        return $duplicate;
    }

    /**
     * @return UserInfo|null
     */
    public function getActiveInfo()
    {
        return $this->infos()->orderBy('created_at', 'DESC')->first();
    }

    /**
     * @param $attribute
     * @return mixed
     */
    public function getInfo( $attribute )
    {
        if($activeInfo = $this->getActiveInfo())

            return $activeInfo->getAttribute($attribute);
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function getAttribute( $key )
    {
        if($value = parent::getAttribute($key)) return $value;

        return $this->getInfo($key);
    }

    /**
     * @return bool
     */
    public function isAdministrator()
    {
        return $this->type == self::ADMINISTRATOR;
    }

    /**
     * @return bool
     */
    public function isDeveloper()
    {
        return $this->type == self::DEVELOPER;
    }

    /**
     * @return bool
     */
    public function isVisitor()
    {
        return $this->type == self::VISITOR;
    }

    /**
     * @return bool
     */
    public function isNormal()
    {
        return $this->type == self::NORMAL;
    }

    /**
     * @return mixed
     * @return string
     */
    public function getTypeString()
    {
        $types = $this->getTypes();

        return ucfirst($types[$this->type]);
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Get the e-mail address where password reminders are sent.
     *
     * @return string
     */
    public function getReminderEmail()
    {
        return $this->email;
    }

    /**
     * Get all users by recipient
     *
     * @param Model $model
     * @return Collection
     */
    public static function getByRecipient( Model $model )
    {
        $recipients = Recipient::where('receiptable_id', $model->id)
            ->where('receiptable_type', get_class($model))
            ->get();

        return $recipients->map(function(Recipient $recipient)
        {
            return $recipient->user;
        });
    }

    /**
     * User receives this model.
     *
     * @param Model $model
     * @return Recipient
     */
    public function receives( Model $model, array $extra = array() )
    {
        return Recipient::create(array(
            'user_id' => $this->id,
            'receiptable_id' => $model->id,
            'receiptable_type' => get_class($model),
            'extra' => serialize($extra)
        ));
    }

    /**
     * Check if user received this model
     *
     * @param Model $model
     * @return bool
     */
    public function hasReceived( Model $model )
    {
        return $this->recipients()->where('receiptable_type', get_class($model))
            ->where('receiptable_id'  , $model->id)
            ->count() > 0;
    }

    /**
     * Get all recipients by the given type and extra if needed.
     *
     * @param string $type
     * @param array $extra
     * @return Collection
     */
    public function getRecipients($type = '', array $extra = array())
    {
        return $this->getRecipientsFromQuery($this->recipients(), $type, $extra);
    }

    /**
     * Get not seen recipients by the given type
     *
     * @param string $type
     * @param array $extra
     * @return Collection
     */
    public function getNotSeenRecipients( $type = '', array $extra = array())
    {
        return $this->getRecipientsFromQuery($this->recipients()->where('seen', false), $type, $extra);
    }

    /**
     * Get seen recipients by the given type.
     *
     * @param string $type
     * @param array $extra
     * @return Collection
     */
    public function getSeenRecipients( $type = '', array $extra = array())
    {
        return $this->getRecipientsFromQuery($this->recipients()->where('seen', true), $type, $extra);
    }

    /**
     * User saw the given model.
     *
     * @param Model $model
     * @return bool
     */
    public function seenRecipient( Model $model )
    {
        $this->getRecipientQuery($model)->update(array('seen' => true));
    }

    /**
     * @param Model $model
     * @param array $extra
     */
    public function setRecipientExtra(Model $model, array $extra = array())
    {
        $this->getRecipientQuery($model)->update(array('extra' => serialize($extra)));
    }

    /**
     * User saw all models in the given type
     *
     * @param $type
     */
    public function seenRecipients( $type )
    {
        $this->getRecipientsQuery($type)->update(array('seen' => true));
    }

    /**
     * @param Model $model
     */
    public function removeRecipient(Model $model)
    {
        $this->getRecipientQuery($model)->delete();
    }

    /**
     * @param $type
     * @return Builder
     */
    protected function getRecipientsQuery( $type )
    {
        return $this->recipients()->where('receiptable_type', $type);
    }

    /**
     * @param Model $model
     * @return Builder
     */
    protected function getRecipientQuery( Model $model )
    {
        return $this->getRecipientsQuery(get_class($model))->where('receiptable_id'  , $model->id);
    }

    /**
     * @param $query
     * @param string $type
     * @param array $extra
     * @return \Illuminate\Support\Collection
     */
    protected function getRecipientsFromQuery($query, $type = '', array $extra = array())
    {
        if(! empty($extra))
        {
            $query->where('extra', serialize($extra));
        }

        if(! $type)

            return $this->extractReceiptable($query->get());

        return $this->extractReceiptable($query->where('receiptable_type', $type)->get());
    }

    /**
     * @param \Illuminate\Support\Collection $collection
     * @return Collection
     */
    protected function extractReceiptable( Collection $collection )
    {
        return $collection->map(function( Recipient $recipient )
        {
            return $recipient->receiptable;
        });
    }

    /**
     * @param Model $model
     * @return Collection
     */
    public static function getByCreation( Model $model )
    {
        $creations = Creation::where('creatable_id', $model->id)
            ->where('creatable_type', get_class($model))
            ->get();

        return $creations->map(function(Creation $creation)
        {
            return $creation->user;
        });
    }

    /**
     * @param Model $model
     * @param array $extra
     * @return Creation
     */
    public function creates( Model $model, array $extra = array() )
    {
        return Creation::create(array(
            'user_id' => $this->id,
            'creatable_id' => $model->id,
            'creatable_type' => get_class($model),
            'extra' => serialize($extra)
        ));
    }


    /**
     * @param Model $model
     * @return bool
     */
    public function hasCreated( Model $model )
    {
        return $this->getCreationQuery($model)->count() > 0;
    }

    /**
     * @param string $type
     * @param array $extra
     * @return Collection
     */
    public function getCreations($type = '', $extra = array())
    {
        $query = $this->creations();

        if(! empty($extra))
        {
            $query->where('extra', serialize($extra));
        }

        if(! $type)

            return $this->extractCreatable($query->get());

        return $this->extractCreatable($query->where('creatable_type', $type)->get());
    }

    /**
     * @param Model $model
     * @param array $extra
     */
    public function setCreationExtra(Model $model, array $extra = array())
    {
        $this->getCreationQuery($model)->update(array('extra' => serialize($extra)));
    }

    /**
     * @param Model $model
     */
    public function removeCreation(Model $model)
    {
        $this->getCreationQuery($model)->delete();
    }

    /**
     * @param Model $model
     */
    protected function getCreationQuery(Model $model)
    {
        return $this->creations()->where('creatable_type', get_class($model))->where('creatable_id', $model->id);
    }

    /**
     * @param \Illuminate\Support\Collection $collection
     * @return Collection
     */
    protected function extractCreatable( Collection $collection )
    {
        return $collection->map(function( Creation $creation )
        {
            return $creation->creatable;
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function infos()
    {
        return $this->hasMany(UserInfo::getClass());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function creations()
    {
        return $this->hasMany(Creation::getClass());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function recipients()
    {
        return $this->hasMany(Recipient::getClass());
    }
}