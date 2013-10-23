<?php

use Kareem3d\Ecommerce\Order;
use \Kareem3d\Freak\Core\Client;
use Kareem3d\Freak\Core\Element;
use Kareem3d\Freak;
use Kareem3d\Freak\Menu\Icon;
use Kareem3d\Freak\Menu\Item;

class ApplicationClient extends Client {

    /**
     * @return Element[]
     */
    public function elements()
    {
        return array(
            Element::withDefaults('product', new Product()),
            Element::withDefaults('category', new Category()),
            Element::withDefaults('order', new Order()),
        );
    }

    /**
     * Load client configurations
     *
     * @param \Kareem3d\Freak $freak
     * @return void
     */
    public function run(Freak $freak)
    {
        ClassLoader::addDirectories(__DIR__ . '/Controllers');
        View::addNamespace('panel', __DIR__ . '/views');

        $freak->modifyElement('product', function(Element $element)
        {
            $element->setController('FreakProductController');
        });

        $freak->modifyElement('category', function(Element $element)
        {
            $element->setController('FreakCategoryController');
        });

        $freak->modifyElement('order', function(Element $element)
        {
            $element->setMenuItem(Item::make(
                $element->getName(), $element->getUri(), Icon::make('icon-archive')
            )->addChildren(array(
                    Item::make('Display all ' . Str::plural($element->getName()), $element->getUri(), Icon::make('icol-inbox'))
                )));
        });
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'application';
    }
}