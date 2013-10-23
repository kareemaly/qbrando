<?php namespace Kareem3d\Freak\DBRepositories;

use Illuminate\Database\Eloquent\Collection;
use Kareem3d\Eloquent\Model;

class Discussion extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'discussions';

    /**
     * @var array
     */
    protected $guarded = array('id');

    /**
     * @param $num
     * @return Collection
     */
    public static function getLatest( $num )
    {
        return static::orderBy('id', 'desc')->take($num)->get();
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Return time ago e.g. 15 minutes ago
     *
     * @return string
     */
    public function getTimeAgo()
    {
        return '15 minutes ago';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function controlPanel()
    {
        return $this->belongsTo(ControlPanel::getClass(), 'control_panel_id');
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return User::getByCreation( $this )->first();
    }
}