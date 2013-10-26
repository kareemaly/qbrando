<?php namespace Kareem3d\Ecommerce;

use Illuminate\Support\Facades\App;
use Kareem3d\Eloquent\Model;

class Product extends Model {

    /**
     * @var string
     */
    protected $currency = 'USD';

    /**
     * @var array
     */
    protected $extensions = array('Images');

    /**
     * @var string
     */
    protected $table = 'products';

    /**
     * @var array
     */
    protected $guarded = array();

    /**
     * @var array
     */
    protected $rules = array(
        'price' => 'required|numeric',
        'offer_price' => 'numeric',
        'category_id' => 'required|exists:categories,id'
    );

    /**
     * @var string
     */
    protected static $specsTable = 'product_specs';

    /**
     * @var array
     */
    protected static $specs = array(
        'title'
    );

    /**
     * @param $value
     * @return Price
     */
    public function getPriceAttribute( $value )
    {
        if($value instanceof Price) return $value;

        return new Price($value, $this->currency);
    }

    /**
     * @param $value
     * @return Price
     */
    public function getOfferPriceAttribute( $value )
    {
        if($value instanceof Price) return $value;

        if($value === $this->price->value())
        {
            $value = 0;
        }

        return new Price($value, $this->currency);
    }

    /**
     * @return Price
     */
    public function getBeforePriceAttribute()
    {
        return $this->hasOfferPrice() ? $this->price : $this->offer_price;
    }

    /**
     * @return Price
     */
    public function getActualPriceAttribute()
    {
        return $this->hasOfferPrice() ? $this->offer_price : $this->price;
    }

    /**
     * @return bool
     */
    public function hasOfferPrice()
    {
        return $this->offer_price->value() > 0;
    }

    /**
     * @return bool
     */
    public function hasCategory()
    {
        return $this->category != null;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function stock()
    {
        return $this->belongsTo(Stock::getClass());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function orders()
    {
        return $this->belongsToMany(App::make('Kareem3d\Ecommerce\Order')->getClass(), 'product_order');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(App::make('Kareem3d\Ecommerce\Category')->getClass());
    }
}