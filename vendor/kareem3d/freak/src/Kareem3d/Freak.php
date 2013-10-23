<?php namespace Kareem3d;

use Kareem3d\Freak\Core\ClientInterface;
use Kareem3d\Freak\Core\DefaultInterface;

use Kareem3d\Freak\Core\Package;
use Kareem3d\Freak\Core\PackageInterface;
use Kareem3d\Freak\Menu\Menu;
use Kareem3d\Freak\DBRepositories\User;
use Kareem3d\Freak\Core\Element;

class Freak implements DefaultInterface {

    /**
     * @var array
     */
    protected $routes = array();

    /**
     * @var Freak\DBRepositories\User
     */
    protected $user;

    /**
     * @var Freak\Menu\Menu
     */
    protected $menu;

    /**
     * @var ClientInterface[]
     */
    protected $clients;

    /**
     * @var PackageInterface[]
     */
    protected $packages;

    /**
     * @var Element[]
     */
    protected $elements = array();

    /**
     * @var Freak
     */
    protected static $instance = null;

    /**
     * @param \Kareem3d\Freak\DBRepositories\User $user
     * @param array $clients
     * @param array $packages
     * @param Freak\Menu\Menu $menu
     * @return \Kareem3d\Freak
     */
    private function __construct(User $user, array $clients, array $packages, Menu $menu)
    {
        $this->user = $user;
        $this->clients = $clients;
        $this->packages = $packages;
        $this->menu = $menu;
    }

    /**
     * @param Freak\DBRepositories\User $user
     * @param array $clients
     * @param array $packages
     * @param Freak\Menu\Menu $menu
     * @return Freak
     */
    public static function factory( User $user, array $clients, array $packages, Menu $menu)
    {
        return static::$instance = new static($user, $clients, $packages, $menu);
    }

    /**
     * @return Freak|null
     */
    public static function instance()
    {
        return static::$instance;
    }

    /**
     * @return Element[]
     */
    public function getClientsElements()
    {
        $elements = array();

        foreach($this->clients as $client)
        {
            foreach($client->elements() as $element)
            {
                $elements[] = $element;
            }
        }

        return $elements;
    }

    /**
     * @return \Kareem3d\Freak\Menu\Menu
     */
    public function getMenu()
    {
        return $this->menu;
    }

    /**
     * @param Freak\Menu\Menu $menu
     */
    public function setMenu(Menu $menu)
    {
        $this->menu = $menu;
    }

    /**
     * @return Freak\Core\Element[]
     */
    public function getElements()
    {
        return $this->elements;
    }

    /**
     * @return Freak\Core\PackageInterface[]
     */
    public function getPackages()
    {
        return $this->packages;
    }

    /**
     * @param array $elements
     */
    public function addElements( array $elements )
    {
        $this->elements = array_merge($this->elements, $elements);
    }

    /**
     * @param $name
     * @return \Kareem3d\Freak\Core\PackageInterface
     */
    public function findPackage( $name  )
    {
        foreach($this->getPackages() as $package)
        {
            if($package->checkName($name))

                return $package;
        }
    }

    /**
     * @param $name
     * @return Element
     */
    public function findClientsElement( $name )
    {
        foreach($this->getClientsElements() as $element)
        {
            if($element->checkName($name))

                return $element;
        }
    }

    /**
     * @param $name
     * @return Element|null
     */
    public function findElement( $name )
    {
        foreach($this->getElements() as $element)
        {
            if($element->checkName($name))

                return $element;
        }
    }

    /**
     * @param $name
     * @param callable $closure
     */
    public function modifyElement( $name, \Closure $closure )
    {
        if($element = $this->findElement($name))
        {
            call_user_func_array($closure, array($element));
        }
    }

    /**
     * @param $name
     * @return ClientInterface
     */
    public function findClient( $name )
    {
        foreach($this->clients as $client)
        {
            if($client->checkName($name))

                return $client;
        }
    }

    /**
     * @return Element|null
     */
    public function getCurrentElement()
    {
        foreach($this->getElements() as $element)
        {
            // Check if the menu item for this element is active and that means
            // that this element is the current active element.
            if($this->getMenu()->isActive($element->getMenuItem()))
            {
                return $element;
            }
        }
    }

    /**
     * Make current element has an active menu
     *
     * @return void
     */
    protected function makeCurrentElementMenuActive()
    {
        foreach($this->getElements() as $element)
        {
            if(strpos(freakUri(), $element->getUri()) === 0)

                $element->getMenuItem()->makeActive();
        }
    }

    /**
     * @return \Kareem3d\Freak\DBRepositories\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Run the freak application
     */
    public function run()
    {
        // Run all clients and add their elements
        foreach($this->clients as $client)
        {
            // Filter client elements and add them to the freak elements
            $this->addElements($this->getUser()->filterElements( $client->elements() ));

            // Run client
            $client->run($this);
        }

        // Run all packages
        foreach($this->getPackages() as $package)
        {
            $package->run($this);
        }


        // Now we run freak .....

        // Add routes for elements...
        foreach ($this->getElements() as $element)
        {
            $this->addRoute('controller', $element->getUri(), $element->getController());

            // Get last time the user was online at and set the alerts of the element to it.
            $element->setAlerts($this->getUser()->getOnlineAt());
        }

        // Add elements menu items
        $this->menu->addRootItems($this->getElementsMenuItems());

        $this->makeCurrentElementMenuActive();
    }

    /**
     * @param $elementName
     * @param $packageName
     */
    public function addElementPackage( $elementName, $packageName )
    {
        if(($element = $this->findElement($elementName)) && ($package = $this->findPackage($packageName)))
        {
            $element->addPackage($package);
        }
    }

    /**
     * @internal parameters
     */
    public function addRoute()
    {
        $this->routes[] = func_get_args();
    }

    /**
     * @return array
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * Setup with the default settings
     *
     * @return $this
     */
    public function useDefaults()
    {
        // Use any default configurations

        return $this;
    }

    /**
     * @return array
     */
    protected function getElementsMenuItems()
    {
        $items = array();

        foreach($this->getElements() as $element)
        {
            $items[] = $element->getMenuItem();
        }

        return $items;
    }
}