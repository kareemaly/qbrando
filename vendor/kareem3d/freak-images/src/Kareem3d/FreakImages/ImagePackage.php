<?php namespace Kareem3d\FreakImages;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Kareem3d\Freak\Core\Package;
use Kareem3d\Freak;
use Kareem3d\Images\Image;
use Kareem3d\Images\ImageFacade;

class ImagePackage extends Package {

    /**
     * Load client configurations
     *
     * @param \Kareem3d\Freak $freak
     * @return void
     */
    public function run(Freak $freak)
    {
        // TODO: Implement run() method.
    }

    /**
     * @return string
     */
    public function formView()
    {
        return View::make('freak-images::image.form', array(
            'model' => $this->getElementData()->getModel(),
            'imageType' => $this->getElementData()->getExtra('image-type', '')
        ));
    }

    /**
     * @return string
     */
    public function detailView()
    {
        return View::make('freak-images::image.detail', array(
            'model' => $this->getElementData()->getModel(),
            'imageType' => $this->getElementData()->getExtra('image-type', '')
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'Image';
    }

    /**
     * @return mixed
     */
    public function store()
    {
        $model = $this->getElementData()->getModel();

        if($file = Input::file('image-file'))
        {
            $group     = $this->getExtraRequired('image-group-name');
            $imageName = $this->getExtra('image-name', $file->getClientOriginalName());

            $type      = $this->getExtra('image-type', '');

            $versions = ImageFacade::versions($group,$imageName, $file, false);

            $image = Image::create(array(
                'title' => $this->getExtra('image-title', $model->title),
                'alt'   => $this->getExtra('image-alt', $model->title)
            ))->add($versions);

            $model->replaceImage( $image, $type );
        }
    }

    /**
     * @return mixed
     */
    public function update(){}

    /**
     * @return bool
     */
    public function exists()
    {
        return false;
    }
}