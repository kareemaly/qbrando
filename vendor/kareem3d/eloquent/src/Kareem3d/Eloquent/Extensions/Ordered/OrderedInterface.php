<?php namespace Kareem3d\Eloquent\Extensions\Ordered;

use Kareem3d\Eloquent\Model;

interface OrderedInterface {

    /**
     * @param int $order
     */
    public function setOrder( $order );

    /**
     * @return int
     */
    public function getOrder();

    /**
     * Exchange orders and save them to database
     *
     * @param Model $model
     */
    public function exchange( Model $model );

    /**
     * This will override the given model which means it will be deleted
     * from database...
     *
     * @param Model $model
     * @return
     */
    public function override( Model $model );

    /**
     * @return int
     */
    public function getLastOrder();

    /**
     * @throws SameOrderException
     */
    public function failIfOrderExists();
}