<?php

use Kareem3d\Ecommerce\Order as Kareem3dOrder;
use Kareem3d\Ecommerce\Price;

class Order extends Kareem3dOrder{

    const WAITING = 0;
    const DELIVERED = 1;
    const NOT_DELIVERED = 2;

    /**
     * @var string
     */
    protected $currency = 'QAR';

    /**
     * @return Collection
     */
    public function getSortedProducts()
    {
        return $this->products->sort(function($a, $b)
        {
            return $a->price > $b->price;
        });
    }

    /**
     * @return int
     */
    public function getTotalItems()
    {
        $items = 0;

        foreach($this->products as $product)
        {
            $items += $product->pivot->qty;
        }

        return $items;
    }

    /**
     * @return int
     */
    public function getNumberOfOfferItems()
    {
        return (int)($this->getTotalItems() / 3);
    }

    /**
     * @return float
     */
    public function getOfferPrice()
    {
        $total = $this->getTotal();

        $items = $this->getSortedProducts();

        $numberOfOfferItems = $this->getNumberOfOfferItems();

        foreach($items as $item)
        {
            for($j = 0; $j < $item->pivot->qty; $j++)
            {
                if($numberOfOfferItems <= 0) break 2;

                $total -= $item->price->value();

                $numberOfOfferItems--;
            }
        }

        return $total;
    }

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