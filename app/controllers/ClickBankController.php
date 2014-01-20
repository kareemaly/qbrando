<?php

class ClickBankController extends BaseController
{

    /**
     * @var Product
     */
    protected $products;

    /**
     * @var ClickBank\CBItem
     */
    protected $cbItems;

    /**
     * @param Product $products
     * @param ClickBank\CBItem $cbItems
     */
    public function __construct(Product $products, \ClickBank\CBItem $cbItems)
    {
        $this->products = $products;
        $this->cbItems = $cbItems;
    }

    /**
     * Show thank you page
     */
    public function thankYou()
    {
        if(! $this->isValidThankYouRequest()) return Redirect::route('home');

        $cbItem = $this->cbItems->find(Input::get('item'));

        $this->layout->template->addPart('body', array('clickbank_thank_you'), compact('cbItem'));
    }

    /**
     * @return bool
     */
    protected function isValidThankYouRequest()
    {
        $key = Config::get('clickbank.key');

        $rcpt    = Input::get('cbreceipt');
        $time    = Input::get('time');
        $cbpop   = Input::get('cbpop');
        $item_id = Input::get('item');

        $xxpop = sha1("$key|$rcpt|$time|$item_id");
        $xxpop = strtoupper(substr($xxpop, 0, 8));

        return $cbpop == $xxpop;
    }

}