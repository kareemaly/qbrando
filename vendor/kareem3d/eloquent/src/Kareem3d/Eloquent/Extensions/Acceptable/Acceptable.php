<?php namespace Kareem3d\Eloquent\Extensions\Acceptable;

use Kareem3d\Eloquent\Extension;

class Acceptable extends Extension implements AcceptableInterface {

    /**
     * @return bool
     */
    public function isAccepted()
    {
        return (boolean) $this->model->accepted;
    }

    /**
     * Accept current object.
     */
    public function accept()
    {
        $this->model->accepted = true;

        $this->model->save();
    }

    /**
     * Unaccept current object.
     */
    public function unaccept()
    {
        $this->model->accepted = false;

        $this->model->save();
    }

    /**
     * Throws an exception if not accepted
     *
     * @throws NotAcceptedException
     */
    public function failIfNotAccepted()
    {
        if(! $this->model->accepted)

            throw new NotAcceptedException;
    }
}