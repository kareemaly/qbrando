<?php

use Kareem3d\Ecommerce\Order as Kareem3dOrder;

class Order extends Kareem3dOrder{

    const WAITING = 0;
    const DELIVERED = 1;
    const NOT_DELIVERED = 2;

    /**
     * @param $from
     * @param $to
     */
    public static function byDateRange($from, $to)
    {
        return static::where('created_at', '>=', $from)->where('created_at', '<=', $to)->orderBy('created_at', 'DESC')->get();
    }

    /**
     * @return bool
     */
    public function isWaiting()
    {
        return $this->status == self::WAITING;
    }

    /**
     * @return bool
     */
    public function isDelivered()
    {
        return $this->status == self::DELIVERED;
    }

    /**
     * @return bool
     */
    public function notDelivered()
    {
        return $this->status == self::NOT_DELIVERED;
    }

}