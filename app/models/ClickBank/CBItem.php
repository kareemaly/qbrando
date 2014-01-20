<?php namespace ClickBank;

use Product;
use Kareem3d\Eloquent\Model;

class CBItem extends Model {

    /**
     * @var string
     */
    protected $table = 'clickbank_items';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @param $array
     * @return \Kareem3d\Eloquent\Model|null
     */
    public static function createUnique(array $array)
    {
        if(! isset($array['product_id'])) return null;

        // First delete product_id
        static::where('product_id', $array['product_id'])->delete();

        if(isset($array['item_id']) && $array['item_id'] > 0)
        {
            // Create new Item
            return static::create($array);
        }
    }

    /**
     * @return string
     */
    public function getPaymentUrlAttribute()
    {
        return 'http://'. $this->item_id .'.qbrando.pay.clickbank.net';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function product()
    {
        return $this->hasOne(Product::getClass());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments()
    {
        return $this->hasMany(CBPayment::getClass());
    }
}