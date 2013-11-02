<?php

use Kareem3d\Marketing\SEO;

class BaseController extends Controller {

    const PER_PAGE = 12;

    /**
     * @var string
     */
    protected $layout = 'layouts.main';

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
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
}