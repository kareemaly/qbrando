<?php namespace Kareem3d\Eloquent\Extensions\Ordered;

use Illuminate\Database\Eloquent\Collection;
use Kareem3d\Eloquent\Model;

class OrderedCollection extends Collection {

    /**
     * @param $order
     * @return Model
     */
    public function getByOrder( $order )
    {
        foreach($this->items as $item)
        {
            if($item->getOrder() == $order) return $item;
        }
    }

    /**
     * Order collection
     *
     * @return $this
     */
    public function order()
    {
        $this->sort(function( Model $a, Model $b )
        {
            if($a->getOrder() == $b->getOrder()) return 0;

            return $a->getOrder() < $b->getOrder() ? -1 : 1;
        });

        return $this;
    }
}