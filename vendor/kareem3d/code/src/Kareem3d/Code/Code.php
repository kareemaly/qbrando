<?php namespace Kareem3d\Code;

use Kareem3d\Eloquent\Model;

class Code extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'codes';

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
    );

    /**
     * For factoryMuff package to be able to fill attributes.
     *
     * @var array
     */
    public static $factory = array(
    );

    /**
     * @return string
     */
    public function getReadyCode()
    {
        return $this->code;
    }

    /**
     * @param array $parameters
     * @return mixed
     */
    public function evaluate( array $parameters = array() )
    {
        extract($parameters);

        return eval($this->getReadyCode());
    }
}