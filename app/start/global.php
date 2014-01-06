<?php

/*
|--------------------------------------------------------------------------
| Register The Laravel Class Loader
|--------------------------------------------------------------------------
|
| In addition to using Composer, you may use the Laravel class loader to
| load your controllers and models. This is useful for keeping all of
| your classes in the "global" namespace without Composer updating.
|
*/

use Illuminate\Database\Eloquent\ModelNotFoundException;

ClassLoader::addDirectories(array(

	app_path().'/commands',
	app_path().'/controllers',
	app_path().'/models',
	app_path().'/database/seeds',
    app_path().'/libraries'

));

\PathManager\Path::init(URL::asset(''), public_path());

/*
|--------------------------------------------------------------------------
| Application Error Logger
|--------------------------------------------------------------------------
|
| Here we will configure the error logger setup for the application which
| is built on top of the wonderful Monolog library. By default we will
| build a rotating log file setup which creates a new file each day.
|
*/

$logFile = 'log-'.php_sapi_name().'.txt';

Log::useDailyFiles(storage_path().'/logs/'.$logFile);

/*
|--------------------------------------------------------------------------
| Application Error Handler
|--------------------------------------------------------------------------
|
| Here you may handle any errors that occur in your application, including
| logging them or displaying custom views for specific errors. You may
| even register several error handlers to handle different types of
| exceptions. If nothing is returned, the default error view is
| shown, which includes a detailed stack trace during debug.
|
*/


$sendMailWithException = function(Exception $exception, $code)
{
    $data = array(
        'errorTitle' => get_class($exception) . ' <br />' . $exception->getMessage(),
        'errorDescription' => 'In file:' . $exception->getFile() . ', In line:'.$exception->getLine() . '',
        'errorPage' => Request::url() . ' : ' . Request::getMethod() . '<br /><br />INPUTS ARE: ' . print_r(Input::all())
     );

    Mail::send('emails.error', $data, function($message)
    {
        $message->to('kareem3d.a@gmail.com', 'Kareem Mohamed')->subject('Error from qbrando');
    });
};

App::error($sendMailWithException);

App::error(function(PaypalException $e, $code) use($sendMailWithException)
{
    call_user_func_array($sendMailWithException, array($e, $code));

    return Redirect::route('message-to-user')
        ->with('title', 'Something went wrong while trying to pay with Paypal')

        ->with('message', 'Please try again. If this error occurred again try to choose pay on delivery.');
});




App::error(function(ModelNotFoundException $e)
{
    return Redirect::route('home');
});

App::missing(function($exception)
{
    return 'Sorry the page you are looking for not found. go to <a href="'.URL::to('').'">Qbrando home page</a>';
});

/*
|--------------------------------------------------------------------------
| Maintenance Mode Handler
|--------------------------------------------------------------------------
|
| The "down" Artisan command gives you the ability to put an application
| into maintenance mode. Here, you will define what is displayed back
| to the user if maintenace mode is in effect for this application.
|
*/

App::down(function()
{
	return Response::make("Site is being updated, We will be right back in 10 minutes.", 503);
});

/*
|--------------------------------------------------------------------------
| Require The Filters File
|--------------------------------------------------------------------------
|
| Next we will load the filters file for the application. This gives us
| a nice separate location to store our route and application filter
| definitions instead of putting them all in the main routes file.
|
*/

require app_path().'/libraries/helpers.php';

require app_path().'/filters.php';

require app_path().'/composers.php';

require app_path().'/bindings.php';

require app_path().'/freak/start.php';