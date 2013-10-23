<?php namespace Kareem3d\Controllers;

use Illuminate\Support\Facades\Input;
use Kareem3d\Freak;
use Kareem3d\Freak\Core\PackageData;

class PackagesController extends FreakController {

    /**
     * @param $package
     * @return mixed
     */
    public function postStore( $package )
    {
        $package = $this->freak()->findPackage( $package );

        foreach(Input::get('packagesData', array()) as $packageData)
        {
            $packageData = PackageData::make($packageData);

            if($packageData) $package->addData($packageData);
        }

        if($package->exists()) return $package->update(Input::all());
        else                   return $package->store(Input::all());
    }
}