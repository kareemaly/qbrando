<?php namespace Kareem3d\Freak\Creation;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Kareem3d\Freak\Repositories\Element;
use Kareem3d\Freak\Repositories\User;

class Creator {

    /**
     * @param $elementName
     * @param $models
     * @param User[] $users
     */
    public function element( $elementName, $models, array $users = array() )
    {
        $model = $models[0];

        $singularModel = strtolower($model);

        $pluralModel = Str::plural($singularModel);

        $singularElement = strtolower($elementName);

        $pluralElement = Str::plural($singularModel);

        // To create an element in this control panel we will go through three steps

        // 1. Create element in the database and attach it to a control panel
        $element = Element::create(array('name' => $elementName));
        $element->attachToControlPanel(freak()->getControlPanel());

        // Attach this element to all users
        foreach($users as $user)
        {
            $element->attachToUser($user);
        }

        // 2. Create resource for this element
        $data = require __DIR__ . '/templates/controller.php';

        file_put_contents(Config::get('freak::general.controllers_path') . '/' . $element->getDefaultController() . '.php', $data);

        // 3. Create view for this element
        
    }
}