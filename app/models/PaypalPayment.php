<?php

class PaypalPayment extends \Kareem3d\Eloquent\Model {

    const AWAITING = 55552;
    const CANCELED = 34113;
    const RECEIVED = 34216;

    /**
     * @var string
     */
    protected $table = 'paypal_payments';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @param $token
     * @return PaypalPayment
     */
    public static function getByToken( $token )
    {
        return static::where('token', $token)->first();
    }

    /**
     * Paypal payment canceled
     */
    public function canceled()
    {
        $this->status = self::CANCELED;
    }

    /**
     * Paypal payment received
     */
    public function received()
    {
        $this->status = self::RECEIVED;
    }

    /**
     * Paypal payment awaiting
     */
    public function awaiting()
    {
        $this->status = self::AWAITING;
    }

    /**
     * @return bool
     */
    public function hasReceived()
    {
        return $this->status == self::RECEIVED;
    }

    /**
     * @return bool
     */
    public function hasCanceled()
    {
        return $this->status == self::CANCELED || ($this->awaiting() && $this->timeout() );
    }

    /**
     * @todo
     * @return bool
     */
    public function timeout()
    {
        return false;
    }

    /**
     * @return bool
     */
    public function isAwaiting()
    {
        return $this->status == self::AWAITING;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::getClass());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function grossAmount()
    {
        return $this->belongsTo(PriceAmount::getClass());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function feeAmount()
    {
        return $this->belongsTo(PriceAmount::getClass());
    }
}