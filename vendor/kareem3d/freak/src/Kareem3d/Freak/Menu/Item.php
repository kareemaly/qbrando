<?php namespace Kareem3d\Freak\Menu;

use Illuminate\Support\Str;

class Item {

    /**
     * @var Item[]
     */
    protected $children = array();

    /**
     * @var Item
     */
    protected $parent = null;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $uri;

    /**
     * @var Icon
     */
    protected $icon;

    /**
     * @var Alert[]
     */
    protected $alerts;

    /**
     * @var
     */
    protected $active = false;

    /**
     * @param $title
     * @param $uri
     * @param $icon
     * @param array $alerts
     */
    public function __construct($title, $uri = '', $icon = null, $alerts = array())
    {
        $this->title  = $title;
        $this->uri    = $uri;
        $this->icon   = $icon;
        $this->alerts = $alerts;
    }

    /**
     * @param $title
     * @param string $uri
     * @param null $icon
     * @param array $alerts
     * @return Item
     */
    public static function make( $title, $uri = '', $icon = null, $alerts = array() )
    {
        return new static($title, $uri, $icon, $alerts);
    }

    /**
     * @return void
     */
    public function makeActive()
    {
        $this->active = true;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->active || Str::is($this->getUri(), freakUri());
    }

    /**
     * @return array|Item[]
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @return bool
     */
    public function hasChildren()
    {
        return count($this->children) > 0;
    }

    /**
     * @param array $children
     * @return Item
     */
    public function addChildren( $children )
    {
        $children = is_array($children) ? $children : func_get_args();

        $that = $this;

        array_map(function(Item $child) use( $that )
        {
            $that->addChild($child);

            $child->setParent($that);

        }, $children);

        return $this;
    }

    /**
     * @param Item $item
     */
    public function addChild( Item $item )
    {
        $this->children[] = $item;
    }

    /**
     * @param Item $item
     */
    public function setParent( Item $item )
    {
        $this->parent = $item;
    }

    /**
     * @return bool
     */
    public function hasParent()
    {
        return $this->parent != null;
    }

    /**
     * @param array $alerts
     */
    public function setAlerts( array $alerts )
    {
        $this->alerts = $alerts;
    }

    /**
     * @return bool
     */
    public function hasAlerts()
    {
        return $this->countAlerts() > 0;
    }

    /**
     * @return int
     */
    public function countAlerts()
    {
        return count($this->getAlerts());
    }

    /**
     * @return array
     */
    public function getAlerts()
    {
        return $this->alerts;
    }

    /**
     * @return Icon
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return $this->uri ?: '#';
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->title;
    }

}