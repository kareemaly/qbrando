<?php

class Municipality extends \Kareem3d\Eloquent\Model {

    /**
     * @var string
     */
    protected static $specsTable = 'municipalities_specs';

    /**
     * @var array
     */
    protected static $specs = array('name');

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return mixed|string
     */
    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function deliveryLocations()
    {
        return $this->hasMany(DeliveryLocation::getClass());
    }

}