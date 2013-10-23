<?php namespace Kareem3d\Freak\Core;

use Kareem3d\Eloquent\Model;
use Kareem3d\Freak\Core\DefaultInterface;
use Kareem3d\Freak\Menu\Icon;
use Kareem3d\Freak\Menu\Item;

class Element implements DefaultInterface {

    /**
     * @var string
     */
    protected $name;

    /**
     * @var \Kareem3d\Eloquent\Model
     */
    protected $model;

    /**
     * @var Package[]
     */
    protected $packages = array();

    /**
     * @var Item
     */
    protected $menuItem;

    /**
     * @var string
     */
    protected $controller;

    /**
     * @var string
     */
    protected $uri;

    /**
     * @param $name
     * @param \Kareem3d\Eloquent\Model $model
     */
    public function __construct( $name, Model $model = null )
    {
        $this->name = $name;
        $this->model = $model;
    }

    /**
     * @param $name
     * @param \Kareem3d\Eloquent\Model $model
     * @return Element
     */
    public static function withDefaults($name, Model $model = null)
    {
        $element = new static($name, $model);

        $element->useDefaults();

        return $element;
    }

    /**
     * @return bool
     */
    public function hasModel()
    {
        return $this->model != null;
    }

    /**
     * @return Model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param Model $model
     */
    public function setModel( Model $model )
    {
        $this->model = $model;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return ucfirst($this->name);
    }

    /**
     * @param $name
     * @return bool
     */
    public function checkName( $name )
    {
        return strtolower($this->name) === strtolower($name);
    }

    /**
     * @param \Kareem3d\Freak\Menu\Item $menuItem
     */
    public function setMenuItem($menuItem)
    {
        $this->menuItem = $menuItem;
    }

    /**
     * @return \Kareem3d\Freak\Menu\Item
     */
    public function getMenuItem()
    {
        return $this->menuItem;
    }

    /**
     * @param \Kareem3d\Freak\Core\Package $package
     */
    public function addPackage($package)
    {
        $this->packages[] = $package;
    }

    /**
     * @param Package[] $packages
     */
    public function setPackages( $packages )
    {
        $this->packages = $packages;
    }

    /**
     * @return \Kareem3d\Freak\Core\Package[]
     */
    public function getPackages()
    {
        return $this->packages;
    }

    /**
     * @param $package
     * @return Package|null
     */
    public function getPackage( $package )
    {
        foreach($this->getPackages() as $package)
        {
            if($package->checkName($package)) return $package;
        }
    }

    /**
     * @param string $controller
     */
    public function setController($controller)
    {
        $this->controller = $controller;
    }

    /**
     * @return string
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @param string $uri
     */
    public function setUri($uri)
    {
        $this->uri = $uri;
    }

    /**
     * @param $append
     * @return string
     */
    public function getUri( $append = '' )
    {
        $uri = rtrim($this->uri, '/'). '/' . trim($append, '/');

        return rtrim($uri, '/');
    }

    /**
     * Setup with the default settings
     *
     * @return $this
     */
    public function useDefaults()
    {
        $this->setUri('element/' . strtolower($this->getName()));

        $this->setController('Freak' . ucfirst($this->getName()) . 'Controller');

        $this->setMenuItem(Item::make(
            $this->getName(), $this->getUri(), Icon::make('icon-archive')
        )->addChildren(array(
            Item::make('Add new ' . $this->getName(), $this->getUri('create'), Icon::make('icol-add')),
            Item::make('Display all ' . $this->getName(), $this->getUri(), Icon::make('icol-inbox'))
        )));

        return $this;
    }

    /**
     * Get number of notifications for this element
     * @param mixed $afterDate
     */
    public function setAlerts( $afterDate )
    {
        $this->menuItem->setAlerts($this->model->getNewerThan($afterDate)->toArray());
    }
}