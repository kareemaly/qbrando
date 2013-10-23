<?php namespace Kareem3d\Controllers;

use Kareem3d\Freak\Creation\Creator;

class CreationController extends FreakController {

    public function __construct( Creator $creator )
    {
        $this->creator = $creator;
    }

    /**
     * @param $element
     * @param $models
     */
    public function getElement($element, $models)
    {
        $this->creator->element($element, explode(',', $models), array(freak()->getAuthUser()));
    }

}