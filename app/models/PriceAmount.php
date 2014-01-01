<?php

class PriceAmount extends \Kareem3d\Eloquent\Model {

    /**
     * @var string
     */
    protected $table = 'price_amounts';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @param $value
     * @return float
     */
    public function getValueAttribute($value)
    {
        return round($value, 2);
    }

    /**
     * @return string
     */
    public function format()
    {
        return strtoupper($this->currency) . ' ' . $this->value;
    }
}