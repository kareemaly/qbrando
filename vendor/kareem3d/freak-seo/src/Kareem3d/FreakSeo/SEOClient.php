<?php namespace Kareem3d\FreakSeo;

use Kareem3d\Freak;
use Kareem3d\Freak\Core\Element;
use Kareem3d\Marketing\SEO;

class SEOClient extends Freak\Core\Client {

    /**
     * @return Element[]
     */
    public function elements()
    {
        return array(Element::withDefaults('SEO', new SEO()));
    }

    /**
     * Load client configurations
     *
     * @param \Kareem3d\Freak $freak
     * @return void
     */
    public function run(Freak $freak)
    {
        $freak->modifyElement('SEO', function(Element $element)
        {
            $element->setController('Kareem3d\FreakSeo\SEOController');
        });
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'SEO';
    }
}