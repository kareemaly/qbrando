<?php

use Illuminate\Support\MessageBag;
use Kareem3d\Marketing\SEO;

class BaseController extends Controller {

    const PER_PAGE = 12;

    /**
     * @var string
     */
    protected $layout = 'layouts.main';

    /**
     * @var \Illuminate\Support\MessageBag
     */
    protected $errors;

    /**
     * @param $errors
     */
    protected function addErrors($errors)
    {
        if(is_array($errors))$this->errors = $this->errors->merge($errors);

        elseif($errors instanceof MessageBag) $this->errors = $this->errors->merge($errors->getMessages());

        elseif($errors instanceof \Kareem3d\Eloquent\Model) $this->addErrors($errors->getValidatorMessages());
    }

    /**
     * @return bool
     */
    protected function emptyErrors()
    {
        return $this->errors->isEmpty();
    }

    /**
     * @return mixed
     */
    protected function redirectBackWithErrors()
    {
        return Redirect::back()->withErrors($this->errors);
    }

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
        $this->errors = new \Illuminate\Support\MessageBag();

		if ( ! is_null($this->layout))
		{
            $this->layout = View::make($this->layout);

            $this->layout->seo = SEO::getCurrent();

            $this->useDefaultTemplate();
		}
	}

    /**
     *
     */
    protected function useDefaultTemplate()
    {
        $this->layout->template = Template::factory(array(

            'header',

            'lower_header' => array('menu'),

            'sidebar'      => array('search', 'specials'),

            'footer'       => array('copyright')

        ));

        $this->layout->template->setLocation('sidebar', 'left');
    }

    /**
     * @param $messageTitle
     * @param $messageBody
     */
    protected function messageToUser($messageTitle, $messageBody)
    {
        $this->layout->template->addPart('body', array('message'), compact('messageTitle', 'messageBody'));
    }
}