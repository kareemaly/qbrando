<?php namespace Kareem3d\Freak;

use Illuminate\Support\Facades\Auth;
use Kareem3d\Freak\DBRepositories\ControlPanel;
use Kareem3d\Freak\DBRepositories\User;

class Environment {

    /**
     * @var ControlPanel
     */
    protected $controlPanel;

    /**
     * @var User
     */
    protected $authUser;

    /**
     * @var Environment
     */
    protected static $instance;

    /**
     * @param DBRepositories\User $authUser
     * @param ControlPanel $controlPanel
     */
    private function __construct( User $authUser = null, ControlPanel $controlPanel = null )
    {
        $this->authUser = $authUser;
        $this->controlPanel = $controlPanel;
    }

    /**
     * @param User $authUser
     * @param ControlPanel $controlPanel
     * @return Environment
     */
    public static function instance( User $authUser = null, ControlPanel $controlPanel = null  )
    {
        if(! static::$instance)

            static::$instance = new static($authUser, $controlPanel);

        return static::$instance;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        $code  = $this->getLogicCharOf( $this->authUser() );
        $code .= $this->getLogicCharOf( $this->developer() );
        $code .= $this->getLogicCharOf( $this->controlPanel() );

        return $code;
    }

    /**
     * @param string $code
     * @return bool
     */
    public function checkCode( $code )
    {
        return strlen($code) === 3
            && $this->checkLogicChar($code[0], $this->authUser())
            && $this->checkLogicChar($code[1], $this->developer())
            && $this->checkLogicChar($code[2], $this->controlPanel());
    }

    /**
     * @param $char
     * @param $boolean
     * @return bool
     */
    public function checkLogicChar( $char, $boolean )
    {
        if($char === 'x') return true;

        return $char === $this->getLogicCharOf($boolean);
    }

    /**
     * @param $boolean
     * @return string
     */
    public function getLogicCharOf( $boolean )
    {
        if($boolean) return '1';
        else         return '0';
    }

    /**
     * @return User
     */
    public function authUser()
    {
        return $this->authUser;
    }

    /**
     * Check if control panel is defined
     *
     * @return bool
     */
    public function controlPanel()
    {
        return $this->controlPanel;
    }

    /**
     * Is authenticated user developer
     *
     * @return bool
     */
    public function developer()
    {
        return $this->authUser() && $this->authUser()->isDeveloper();
    }

}