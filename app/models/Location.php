<?php

class Location extends \Kareem3d\Eloquent\Model {

    /**
     * @var string
     */
    protected $table = 'locations';

    /**
     * @var array
     */
    protected $rules = array(
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',
        'municipality_id' => 'required|exists:municipalities,id',
    );

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->hasOne(Order::getClass());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function municipality()
    {
        return $this->belongsTo(Municipality::getClass());
    }
}