<?php namespace Kareem3d\Eloquent\Extensions\Ordered;

use Kareem3d\Eloquent\Extension;
use Kareem3d\Eloquent\Model;

class Ordered extends Extension implements OrderedInterface {


    /**
     * @return int
     */
    public function getOrder()
    {
        return $this->model->order;
    }

    /**
     * @param $order
     */
    public function setOrder( $order )
    {
        $this->model->order = $order;
    }

    /**
     * Exchange orders and save them to database
     *
     * @param Model $model
     */
    public function exchange( Model $model )
    {
        if($model->doesUse('Ordered'))
        {
            $modelOrder = $model->getOrder();

            $model->setOrder($this->getOrder());
            $this->setOrder($modelOrder);

            $model->save();
            $this->model->save();
        }
    }

    /**
     * This will override the given model which means it will be deleted
     * from database...
     *
     * @param Model $model
     */
    public function override( Model $model)
    {
        if($model->doesUse('Ordered'))
        {
            // Set the order to the same model order
            $this->setOrder($model->getOrder());

            $model->delete();
        }
    }

    /**
     * @return mixed
     */
    public function orderExists()
    {
        return $this->getOrderGroup()
                    ->where('order', $this->model->order)
                    ->where('id', '!=', $this->model->id)->count() > 0;
    }

    /**
     * @throws SameOrderException
     */
    public function failIfOrderExists()
    {
        if($this->orderExists())

            throw new SameOrderException;
    }

    /**
     * @throws SameOrderException
     * @return void
     */
    public function beforeSave()
    {
        // If order is not set then set it to the last order + 1
        if(is_null($this->getOrder()))

            $this->setOrder($this->getLastOrder() + 1);
    }

    /**
     * @return int
     */
    public function getLastOrder()
    {
        return $this->getOrderGroup()->max('order');
    }

    /**
     * Override this to group your ordered objects
     *
     * @return \Illuminate\Database\Query\Builder
     */
    protected function getOrderGroup()
    {
        return $this->model->query();
    }

    /**
     * That will override the collection for this model..
     *
     * @param array $models
     * @return OrderedCollection
     */
    public static function newCollection(array $models = array())
    {
        return new OrderedCollection($models);
    }
}