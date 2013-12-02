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
     * @return \Illuminate\Support\Collection
     */
    public function getSortedProducts()
    {
        // Dont remove products()->get() .. It prevents cloning issues

        return $this->products()->get()->sort(function($a, $b)
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
        $total = 0;

        $products = $this->getProductsAfterOffer();

        foreach($products as $product)
        {
            $total += $product->pivot->qty * $product->actualPrice->value();
        }

        return $total;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getProductsAfterOffer()
    {
        $products = $this->getSortedProducts();

        $numberOfOfferItems = $this->getNumberOfOfferItems();

        for($i = 0; $i < count($products); $i++)
        {
            $qty = $products[$i]->pivot->qty;

            for($j = 0; $j < $qty; $j++)
            {
                if($numberOfOfferItems <= 0) break 2;

                $numberOfOfferItems--;

                $products[$i]->pivot->qty --;

                if($products[$i]->pivot->qty <= 0)
                {
                    $products->forget($i);

                    break;
                }
            }
        }

        return $products;
    }

    /**
     * @return bool
     */
    public function hasOffer()
    {
        return $this->getNumberOfOfferItems() > 0;
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