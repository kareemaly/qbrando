<?php

use Illuminate\Support\Collection;

class Cart extends Moltin\Cart\Facade {


    public static function totalWithOffer()
    {
        $total = static::total();

        $items = static::sortedContents();

        $numberOfOfferItems = static::getNumberOfOfferItems();

        foreach($items as $item)
        {
            for($j = 0; $j < $item->quantity; $j++)
            {
                if($numberOfOfferItems <= 0) break 2;

                $total -= $item->price;

                $numberOfOfferItems--;
            }
        }

        return $total;
    }

    /**
     * @return int
     */
    public static function getNumberOfOfferItems()
    {
        return (int)(static::totalItems() / 3);
    }

    /**
     * @return mixed
     */
    public static function sortedContents()
    {
        $contents = static::contents();

        usort($contents, function( $a, $b )
        {
            return $a->price > $b->price;
        });

        return $contents;
    }

    /**
     * @param Product $product
     * @param int $quantity
     */
    public static function addProduct( Product $product, $quantity = 1 )
    {
        static::insert(array(
            'id' => $product->id,
            'name' => $product->title,
            'image' => $product->getImage('main')->getSmallest()->url,
            'price' => (string) $product->actualPrice,
            'quantity' => $quantity
        ));
    }

    /**
     * @param $array
     */
    public static function insert( $array )
    {
        if(isset($array['title'])) {

            $array['name'] = $array['title'];

            unset($array['title']);
        }

        return parent::insert($array);
    }

    /**
     * Update all local products..
     */
    public static function setFromLocal()
    {
        if(isset($_COOKIE['products']))
        {
            static::destroy();

            $products = json_decode($_COOKIE['products']);

            foreach($products as $product)
            {
                try{

                    static::addProduct(Product::find($product->id), $product->quantity);

                }catch(Exception $e){}
            }

            setcookie("products", "", time()-3600);
        }
    }

    /**
     * @param bool $array
     */
    public static function contents( $array = false )
    {
        $items = parent::contents($array);

        // Modify name to title
        foreach($items as &$item)
        {
            if($array)
            {
                $item['title'] = $item['name'];

                unset($item['name']);
            }
            else
            {
                $item->title = $item->name;
                unset($item->title);
            }
        }

        return $items;
    }

}