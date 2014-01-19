<?php

class Country extends \Kareem3d\Eloquent\Model {

    /**
     * @var string
     */
    protected static $specsTable = 'countries_specs';

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
     * @return string
     */
    public static function jsObject()
    {
        $string = '{';

        foreach(static::with('municipalities')->get() as $country)
        {
            $string .= "'{$country->name}': {$country->jsArrayMunicipalities()},";
        }

        return rtrim($string, ',') . '}';
    }

    /**
     * @return string
     */
    public function jsArrayMunicipalities()
    {
        $string = '[';

        foreach($this->municipalities as $m) {
            $string .= "{'id':'{$m->id}', 'name':'{$m->name}'},";
        }

        return rtrim($string, ',') . ']';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function municipalities()
    {
        return $this->hasMany(Municipality::getClass());
    }


}