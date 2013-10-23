<?php namespace Kareem3d\Ecommerce;

use Illuminate\Support\Facades\App;
use Kareem3d\Eloquent\Model;
use Kareem3d\Membership\UserInfo;

class Order extends Model {

    /**
     * @var string
     */
    protected $table = 'orders';

    /**
     * @var array
     */
    protected $guarded = array();

    /**
     * @return float
     */
    public function getTotal()
    {
        $total = 0;

        foreach($this->products as $product)
        {
            $total +=  ((int)$product->qty) * ((float)$product->getActualPrice());
        }

        return $total;
    }

    /**
     * @return float
     */
    public function getTotalWithoutOffer()
    {
        $total = 0;

        foreach($this->products as $product)
        {
            $total +=  ((int)$product->qty) * ((float)$product->price);
        }

        return $total;
    }

    /**
     * @param Product $product
     * @param $qty
     */
    public function updateProduct( Product $product, $qty )
    {
        $this->removeProduct($product);

        $this->addProduct($product, $qty);
    }

    /**
     * @param Product $product
     * @param $qty
     */
    public function addProduct( Product $product, $qty )
    {
        $this->products()->attach($product, array('qty' => $qty));
    }

    /**
     * @param Product $product
     * @return int
     */
    public function removeProduct( Product $product )
    {
        return $this->products()->detach( $product );
    }

    /**
     * @return int
     */
    public function countProducts()
    {
        return $this->products()->count();
    }

    /**
     * @param \Kareem3d\Membership\UserInfo $userInfo
     */
    public function setUserInfo( UserInfo $userInfo )
    {
        $this->userInfo()->associate($userInfo);

        if(! $this->exists) $this->save();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(App::make('Kareem3d\Ecommerce\Product')->getClass(), 'product_order')->withPivot('qty');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userInfo()
    {
        return $this->belongsTo(App::make('Kareem3d\Membership\UserInfo')->getClass(), 'user_info_id');
    }
}