<?php namespace Kareem3d\Images\Extensions;

use Kareem3d\Eloquent\Extension;
use Kareem3d\Eloquent\Extensions\Ordered\OrderedCollection;
use Kareem3d\Images\Image;

class Images extends Extension {

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function images()
    {
        return $this->model->morphMany(Image::getClass(), 'imageable');
    }

    /**
     * @return mixed
     */
    public function getAllImages()
    {
        return $this->model->images()->get();
    }

    /**
     * @param string $type
     * @return OrderedCollection
     */
    public function getImages( $type = '' )
    {
        if(! $type) return $this->getAllImages();

        return $this->model->images()->where('type', $type)->get();
    }

    /**
     * @param string $type
     * @return Image
     */
    public function getImage( $type = '' )
    {
        if(! $type) return $this->model->images()->first();

        $image = $this->model->images()->where('type', $type)->first();

        return $image ?: new Image;
    }

    /**
     * @param string $type
     * @return OrderedCollection
     */
    public function getImagesExcept( $type = '' )
    {
        if(! $type) return $this->getAllImages();

        return $this->model->images()->where('type', '!=', $type)->get();
    }

    /**
     * @param \Kareem3d\Images\Image $image
     * @param string $type
     * @return bool
     */
    public function addImage( Image $image, $type = '' )
    {
        if($type) $image->type = $type;

        return $this->model->images()->save($image);
    }

    /**
     * @param array $images
     * @param string $type
     * @return int Number of images added successfully.
     */
    public function addImages( array $images, $type = '' )
    {
        $i = 0;

        foreach($images as $image) {

            if($this->addImage($image, $type)) $i++;
        }

        return $i;
    }

    /**
     * @param array $images
     * @param string $type
     * @return int
     */
    public function replaceImages( array $images, $type = '' )
    {
        $this->deleteImages( $type );

        return $this->addImages($images, $type);
    }

    /**
     * @param Image $image
     * @param string $type
     * @return bool
     */
    public function replaceImage( Image $image, $type = '' )
    {
        $this->deleteImages($type);

        return $this->addImage($image, $type);
    }

    /**
     * @param string $type
     * @return bool
     */
    public function deleteImages( $type = '' )
    {
        if($type) $this->images()->where('type', $type)->delete();

        else $this->images()->delete();
    }
}