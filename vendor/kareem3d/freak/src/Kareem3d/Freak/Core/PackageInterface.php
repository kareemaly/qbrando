<?php namespace Kareem3d\Freak\Core;

interface PackageInterface extends FreakRunnableInterface {

    /**
     * @param array|\Kareem3d\Freak\Core\PackageData $data
     * @return mixed
     */
    public function addData(PackageData $data);

    /**
     * @param array $data
     * @return void
     */
    public function setData(array $data);

    /**
     * @return string
     */
    public function formView();

    /**
     * @return string
     */
    public function detailView();

    /**
     * @return string
     */
    public function getName();

    /**
     * @param $name
     * @return string
     */
    public function checkName( $name );

    /**
     * @return mixed
     */
    public function store();

    /**
     * @return mixed
     */
    public function update();

    /**
     * @return bool
     */
    public function exists();
}