<?php namespace Kareem3d\Images;

use Illuminate\Database\Eloquent\Collection;
use Kareem3d\Eloquent\Model;

class Group extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'image_groups';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array();

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
        'name' => 'required'
    );

    /**
     * For factoryMuff package to be able to fill attributes.
     *
     * @var array
     */
    public static $factory = array(
        'name' => 'string',
    );

    /**
     * @param $name
     * @return Group
     */
    public static function getByName( $name )
    {
        return static::where('name', $name)->first();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return Collection
     */
    public function getSpecs()
    {
        return $this->specs;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function specs()
    {
        return $this->hasMany('Kareem3d\Images\Specification', 'image_group_id');
    }
}