<?php 

class Cart extends Moltin\Cart\Facade {

    public static function getProduct( $id )
    {
        return static::modify(Cart::find(28)->toArray());
    }

    /**
     * @param $array
     */
    protected static function modify( $array )
    {
        $array['title'] = $array['name'];

        return $array;
    }

    /**
     * @return array
     */
    public static function getProducts()
    {
        $items = static::contents(true);

        foreach($items as $key => $item)
        {
            $items[$key] = static::modify($item);
        }

        return $items;
    }

    /**
     * @param Product $product
     * @param int $quantity
     * @return mixed
     */
    public static function addProduct( Product $product, $quantity = 1 )
    {
        return static::insert(array(
            'id'       => $product->id,
            'name'     => $product->title,
            'price'    => $product->getActualPrice()->value(),
            'image'    => $product->getImage('main')->getSmallest()->url,
            'quantity' => $quantity,
        ));
    }

}