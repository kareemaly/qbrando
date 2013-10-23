<?php namespace Kareem3d\Freak\Menu;

class Icon {

    /**
     * @var string
     */
    protected $name;

    /**
     * @param $name
     */
    public function __construct( $name )
    {
        $this->name = $name;
    }

    /**
     * @param $name
     * @return static
     */
    public static function make( $name )
    {
        return new static($name);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return '<i class="' . $this->name . '"></i>';
    }
}