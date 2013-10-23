<?php namespace Kareem3d\Freak\Core;

use Kareem3d\Freak\Menu\Item;
use Kareem3d\Freak\Core\Element;
use Kareem3d\Freak\Core\Package;

interface ClientInterface extends FreakRunnableInterface {

    /**
     * @return Element[]
     */
    public function elements();

    /**
     * @return string
     */
    public function getName();

    /**
     * @param $name
     * @return string
     */
    public function checkName( $name );
}