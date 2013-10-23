<?php namespace Kareem3d\Eloquent;

abstract class Extension {

    /**
     * @var Model
     */
    protected $model;

    /**
     * @param Model $model
     */
    public function __construct( Model $model )
    {
        $this->model = $model;
    }

    /**
     * @param Model $model
     */
    public function setModel( Model $model )
    {
        $this->model = $model;
    }

    /**
     * @return Model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @return string
     */
    public static function getClass()
    {
        return get_called_class();
    }
}