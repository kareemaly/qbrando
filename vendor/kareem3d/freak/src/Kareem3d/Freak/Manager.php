<?php namespace Kareem3d\Freak;

use Asset\Asset;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\URL;
use Kareem3d\Freak\DBRepositories\ControlPanel;

class Manager {

    /**
     * @var array
     */
    protected $paths;

    /**
     * @param array $paths
     */
    public function __construct( $paths )
    {
        $this->paths = $paths;
    }

    /**
     *
     */
    public function start()
    {
        if($this->freakRequest())
        {
            $this->requireHelpersFile();

            // Initialize asset class
            Asset::init(URL::asset('packages/kareem3d/freak'), $this->paths['assets'] . '/plugins', $this->paths['assets']);

            // Set authentication model to freak user.
            Config::set('auth.model', \Kareem3d\Freak\DBRepositories\User::getClass());

            // Bind freak user to the kareem3d\Membership\User
            App::bind('Kareem3d\Membership\User', function()
            {
                return new \Kareem3d\Freak\DBRepositories\User();
            });

            $this->setEnvironment();

            $this->requireEnvironmentFiles();
        }
    }

    /**
     * Require helpers file
     */
    protected function requireHelpersFile()
    {
        require $this->paths['helpers'];
    }


    /**
     * Set environment
     */
    protected function setEnvironment()
    {
        // Set environment
        $user = Auth::user();

        $controlPanel = $user ? ControlPanel::getCurrent($user) : null;

        // Set environment
        Environment::instance($user, $controlPanel);
    }

    /**
     * Require environment files...
     */
    protected function requireEnvironmentFiles()
    {
        foreach(glob($this->paths['environments'] . '/*') as $file)
        {
            $pathinfo = pathinfo($file);

            $checkName = basename($pathinfo['filename']);

            if(is_dir($file)) $file .= '/start.php';

            if(freakEnvironment()->checkCode( $checkName )) require $file;
        }
    }

    /**
     * @return bool
     */
    protected function freakRequest()
    {
        $domain = trim(Config::get('freak::general.domain'), '/');
        $prefix = trim(Config::get('freak::general.prefix'), '/');

        $path = trim(Request::path(), '/');

        if($prefix)
        {
            if(strpos($path, $prefix) !== 0) return false;
        }

        if($domain)
        {
            if(Request::getHttpHost() != $domain) return false;
        }

        return true;
    }
}