<?php namespace Kareem3d\Eloquent\Extensions\Polymorphic;

use Kareem3d\Eloquent\Model;

interface PolymorphicInterface {

    /**
     * @param Model $model
     * @return void
     */
    public function attachTo( Model $model );

    /**
     * @param Model $model
     * @return bool
     */
    public function isAttachedTo( Model $model );

    /**
     * @param Model $model
     * @return Model
     */
    public function getAttachedTo( Model $model );

}