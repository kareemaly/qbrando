<?php namespace Kareem3d\FreakImages;

use Asset;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Kareem3d\Freak\Core\Package;
use Kareem3d\Freak;
use Kareem3d\Images\Image;
use Kareem3d\Images\ImageFacade;

class ImagesPackage extends Package {

    /**
     * This let's the packages controller determine whether to call the update or store method.
     *
     * @return bool
     */
    public function exists()
    {
        return false;
    }

    /**
     * Update existing data
     *
     * @return mixed
     */
    public function update(){}

    /**
     * Store new data
     *
     * @return mixed
     */
    public function store()
    {
        $files = Input::file('images', array());

        $group = $this->getExtraRequired('images-group-name');

        $model = $this->getElementData()->getModel();

        $title = $this->getExtra('images-title', $model->title);

        $alt = $this->getExtra('images-alt', $title);

        $imagesTypes = $this->getExtra('images-type', '');

        foreach($files as $file)
        {
            $imageName = $this->getExtra('images-name', $file->getClientOriginalName());

            $versions = ImageFacade::versions( $group, $imageName, $file, false );

            $image = Image::create(array(
                'title' => $title,
                'alt'   => $alt,
            ))->add($versions);

            $model->addImage($image, $imagesTypes);
        }
    }

    /**
     * @return string
     */
    public function formView()
    {
        Asset::addPlugins(array('sheepit'));

        return View::make('freak-images::images.form', array(
            'model' => $this->getElementData()->getModel(),
            'imagesType' => $this->getElementData()->getExtra('images-type', '')
        ));
    }

    /**
     * @return string
     */
    public function detailView()
    {
        return View::make('freak-images::images.detail', array(
            'model' => $this->getElementData()->getModel(),
            'imagesType' => $this->getElementData()->getExtra('images-type', '')
        ));
    }

    /**
     * Load client configurations
     *
     * @param \Kareem3d\Freak $freak
     * @return void
     */
    public function run(Freak $freak)
    {
        $freak->addRoute('get', 'resource/image/delete/{id}', function($id)
        {
            Image::find($id)->delete();

            return Redirect::back()->with('success', 'Image deleted successfully');
        });
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'Images';
    }
}