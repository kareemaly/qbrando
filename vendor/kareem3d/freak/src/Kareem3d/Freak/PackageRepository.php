<?php namespace Kareem3d\Freak;

use Kareem3d\Freak\Core\PackageInterface;

class PackageRepository {

    /**
     * @var PackageInterface[]
     */
    protected static $registered = array();

    /**
     * @return PackageInterface[]
     */
    public static function getRegistered()
    {
        return static::$registered;
    }

    /**
     * @param PackageInterface $package
     */
    public static function register( PackageInterface $package )
    {
        static::$registered[] = $package;
    }
}