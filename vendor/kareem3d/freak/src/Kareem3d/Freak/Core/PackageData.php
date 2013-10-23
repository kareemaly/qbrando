<?php namespace Kareem3d\Freak\Core;

use Kareem3d\Eloquent\Model;

class PackageData {

    /**
     * @var \Kareem3d\Eloquent\Model
     */
    protected $model;

    /**
     * @var string
     */
    protected $from;

    /**
     * @var array
     */
    protected $extra = array();

    /**
     * @param Model $model
     * @param $from
     * @param array $extra
     * @return \Kareem3d\Freak\Core\PackageData
     */
    public function __construct(Model $model, $from, $extra = array())
    {
        $this->model = $model;
        $this->from  = $from;
        $this->extra = $extra;
    }

    /**
     * @param $data
     * @return PackageData|null
     */
    public static function make( $data )
    {
        if(static::validateDataModel($data))
        {
            return new static(static::generateModel($data['model_type'], $data['model_id']), $data['from'], isset($data['extra']) ? $data['extra'] : array());
        }
    }

    /**
     * @return array
     */
    protected static function getRequiredDataModelKeys()
    {
        return array('model_id', 'model_type', 'from');
    }

    /**
     * @param $dataModel
     * @return bool
     */
    protected static function validateDataModel( $dataModel )
    {
        $isset = true;

        foreach(static::getRequiredDataModelKeys() as $key){

            if(! isset($dataModel[$key])) $isset = false;
        }

        return $isset;
    }

    /**
     * @param $type
     * @param $id
     * @return Model|null
     */
    protected static function generateModel($type, $id)
    {
        if(class_exists($type))
        {
            return $type::find($id);
        }
    }

    /**
     * @return string
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @return \Kareem3d\Eloquent\Model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @return bool
     */
    public function fromElement()
    {
        return $this->from == 'element';
    }

    /**
     * @param $package
     * @return bool
     */
    public function fromPackage( $package )
    {
        return $this->from == $package;
    }

    /**
     * @param $key
     * @return bool
     */
    public function hasExtra( $key )
    {
        return isset($this->extra[$key]);
    }

    /**
     * @param $key
     * @param string $default
     * @return string
     */
    public function getExtra( $key, $default = '' )
    {
        return isset($this->extra[$key]) ? $this->extra[$key] : $default;
    }
}