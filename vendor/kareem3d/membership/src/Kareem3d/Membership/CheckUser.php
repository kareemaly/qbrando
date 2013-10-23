<?php namespace Kareem3d\Membership;

use Kareem3d\Membership\User;
use \Symfony\Component\HttpKernel\Exception\HttpException;

use Illuminate\Support\Facades\Auth;

class CheckUser {

    /**
     * @return User
     */
    public static function getUser()
    {
        return Auth::user();
    }

    /**
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     * @return User
     */
    public static function authenticated()
    {
        if(! $user = static::getUser()) throw new HttpException(401);

        return $user;
    }

    /**
     * @return bool
     */
    public static function notAuthenticated()
    {
        if($user = static::getUser()) return false;
    }

    /**
     * @return bool
     */
    public static function visitor()
    {
        $user = static::authenticated();

        return $user->isVisitor();
    }

    /**
     * @throws NoAccessException
     * @return bool
     */
    public static function normal()
    {
        $user = static::authenticated();

        return $user->isNormal();
    }

    /**
     * @throws NoAccessException
     * @return bool
     */
    public static function administrator()
    {
        $user = static::authenticated();

        return $user->isAdministrator();
    }

    /**
     * @throws NoAccessException
     * @return bool
     */
    public static function developer()
    {
        $user = static::authenticated();

        return $user->isDeveloper();
    }

    /**
     * This method will throw NoAccessException if non of the given parameters are correct
     * e.g. failIfNot('developer', 'administrator'); => This will only fail if user is neither
     * a developer or administrator.
     *
     * @throws NoAccessException
     */
    public static function failIfNotIn()
    {
        if(! static::isIn(func_get_args()))
        {
            throw new NoAccessException;
        }
    }

    /**
     * Check to see if user type is in the given parameters
     * e.g. isIn('developer', 'administrator'); => will return true if user is developer OR administrator.
     *
     * @param array $types
     * @return bool
     */
    public static function isIn(array $types)
    {
        foreach($types as $type)
        {
            if(method_exists(get_called_class(), $type))
            {
                $check = call_user_func_array(array(get_called_class(), $type), array());

                if($check) return true;
            }
        }
    }
}