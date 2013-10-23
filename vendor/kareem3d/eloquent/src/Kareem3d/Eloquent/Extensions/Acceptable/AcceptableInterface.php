<?php namespace Kareem3d\Eloquent\Extensions\Acceptable;

interface AcceptableInterface {

    /**
     * Accept current object.
     *
     * @return void
     */
    public function accept();

    /**
     * Un accept current object.
     *
     * @return void
     */
    public function unAccept();

    /**
     * Throws an exception if not accepted
     *
     * @throws NotAcceptedException
     * @return void
     */
    public function failIfNotAccepted();

}