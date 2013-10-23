<?php namespace Kareem3d\Freak;

use Kareem3d\Freak\Core\ClientInterface;

class ClientRepository {

    /**
     * @var ClientInterface[]
     */
    protected static $clients;

    /**
     * @return ClientInterface[]
     */
    public static function getRegistered()
    {
        return static::$clients;
    }

    /**
     * @param ClientInterface $client
     */
    public static function register( ClientInterface $client )
    {
        static::$clients[] = $client;
    }
}