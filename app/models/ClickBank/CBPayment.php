<?php namespace ClickBank;

use Kareem3d\Eloquent\Model;

class CBPayment extends Model {

    /**
     * @var string
     */
    protected $table = 'clickbank_payments';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function item()
    {
        return $this->belongsTo(CBItem::getClass());
    }
}