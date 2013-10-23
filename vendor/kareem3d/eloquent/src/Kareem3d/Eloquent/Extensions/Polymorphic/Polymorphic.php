<?php namespace Kareem3d\Eloquent\Extensions\Polymorphic;

use Kareem3d\Eloquent\Extension;
use Kareem3d\Eloquent\Model;

class Polymorphic extends Extension implements PolymorphicInterface {

    /**
     * @param Model $model
     * @throws \Exception
     */
    public function __construct(Model $model)
    {
        parent::__construct($model);

        if(! $this->model->polymorphicColumn)

            throw new \Exception("Polymorphic column is not set.");
    }

    /**
     * @param Model $model
     * @return void
     */
    public function attachTo(Model $model)
    {
        if($model->id)
        {
            $this->model->setAttribute($this->getColumnType(), get_class($model));

            $this->model->setAttribute($this->getColumnId(), $model->id);

            $this->model->save();
        }
    }

    /**
     * @param Model $model
     * @return bool
     */
    public function isAttachedTo(Model $model)
    {
        return ! $this->getAttachedTo($model)->isEmpty();
    }

    /**
     * @param Model $model
     * @return Model
     */
    public function getAttachedTo(Model $model)
    {
        return $this->model->where($this->getColumnType(), get_class($model))
                           ->where($this->getColumnId(), $model->id)
                           ->get();
    }

    /**
     * @return string
     */
    protected function getColumnType()
    {
        return $this->model->polymorphicColumn . '_type';
    }

    /**
     * @return string
     */
    protected function getColumnId()
    {
        return $this->model->polymorphicColumn . '_id';
    }
}