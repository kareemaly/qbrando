<?php namespace Kareem3d\Images;

use Kareem3d\Code\Code;
use Kareem3d\Eloquent\Model;

class Specification extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'image_specifications';

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
        'image_group_id' => 'required|exists:image_groups,id'
    );

    /**
     * For factoryMuff package to be able to fill attributes.
     *
     * @var array
     */
    public static $factory = array(
        'directory' => 'string',
        'image_group_id' => 'factory|Kareem3d\Images\Group'
    );

    /**
     * @return string
     */
    public function getDirectory()
    {
        return $this->directory;
    }

    /**
     * @param $imageName
     * @return string
     */
    public function getPath( $imageName )
    {
        return rtrim($this->getDirectory(), '\\/') . '/' . $imageName;
    }

    /**
     * @param Code $code
     */
    public function setCode(Code $code)
    {
        $this->code()->delete();

        $code->save();

        $this->code()->associate($code);

        $this->save();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function code()
    {
        return $this->belongsTo('Kareem3d\Code\Code');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo('Kareem3d\Images\Group', 'image_group_id');
    }
}