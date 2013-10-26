<?php namespace Kareem3d\Ecommerce;

class Price {

    /**
     * @var float
     */
    protected $value;

    /**
     * @var string
     */
    protected $currency;

    /**
     * @param $value
     * @param $currency
     */
    public function __construct( $value, $currency )
    {
        $this->value = (float) $value;
        $this->currency = $currency;
    }

    /**
     * @return string
     */
    public function value()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function format()
    {
        return $this->currency. ' ' .number_format($this->value, 2);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->value();
    }
}