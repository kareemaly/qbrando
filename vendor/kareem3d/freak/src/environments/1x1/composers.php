<?php

// Share across views
use Illuminate\Support\Facades\View;
use Kareem3d\Freak;
use Kareem3d\Freak\DBRepositories\Message;
use Kareem3d\Freak\Environment;

VIew::share('authUser', Freak::instance()->getUser());

View::share('menu', Freak::instance()->getMenu());

View::share('element', Freak::instance()->getCurrentElement());

View::share('controlPanel', Environment::instance()->controlPanel());

if($activeLeaf = Freak::instance()->getMenu()->getActiveLeaf())
{
    View::share('leafTitle', $activeLeaf->getTitle());
}

// Views composers
View::composer('freak::master.layout1', function($view)
{
    Asset::addPage( 'main' );
});

View::composer('freak::master.header', function($view)
{
//    $view->notifications = freak()->getAuthUser()->getRecipients( Notification::getClass() )->take(10);

    $view->notifications = new \Illuminate\Support\Collection(array());

    $view->messages = Message::inbox(Freak::instance()->getUser());

    $view->newMessages = Freak::instance()->getUser()->getNotSeenRecipients(Message::getClass())->count();
});

View::composer('freak::elements.filterable', function($view)
{
    Asset::addPlugin('datatables');
});


View::composer(array('freak::elements.add', 'freak::elements.empty_add'), function($view)
{
    Asset::addPlugin('form');
    Asset::addPage('element_add');
});
