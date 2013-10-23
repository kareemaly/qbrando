<?php namespace Kareem3d\Controllers;

use Kareem3d\Freak\Manager;
use Kareem3d\Freak\Repositories\ControlPanel;

class SettingsController extends FreakController {

    /**
     * @var \Kareem3d\Freak\Repositories\ControlPanel
     */
    protected $controlPanels;

    /**
     * @param \Kareem3d\Freak\Repositories\ControlPanel $controlPanels
     * @return \Kareem3d\Controllers\SettingsController
     */
    public function __construct( ControlPanel $controlPanels )
    {
        $this->controlPanels = $controlPanels;
    }

    /**
     * @return mixed
     */
    public function getChooseControlPanel()
    {
        dd('settings');
        return View::make('settings.choose_control_panel');
    }

    /**
     * @return mixed
     */
    public function postChooseControlPanel()
    {
        // Get control panel by id
        $controlPanel = $this->controlPanels->find( Input::get('Controlpanel.id') );

        // Set it to be the current control panel.
        $this->controlPanels->setCurrent($controlPanel);

        return $this->redirectWithSuccess('You choosed the ' . $controlPanel->name . ' control panel');
    }
}