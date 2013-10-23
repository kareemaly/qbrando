<?php namespace Kareem3d\Images;

use PathManager\Path;
use Intervention\Image\Image as ImageUploader;

class ImageManager {

    /**
     * @var Group
     */
    protected $group;

    /**
     * @var Path
     */
    protected $path;

    /**
     * @var Version
     */
    protected $versions;

    /**
     * @param Group $group
     * @param Path $path Base path
     * @param Version $versions
     * @return \Kareem3d\Images\ImageManager
     */
    public function __construct(Group $group, Path $path, Version $versions)
    {
        $this->group    = $group;
        $this->path     = $path;
        $this->versions = $versions;
    }

    /**
     * @param ImageUploader $imageUploader
     * @param string $imageName
     * @param bool $override
     * @param Specification $specification
     *
     * @return Version|Version[]
     */
    public function upload(ImageUploader $imageUploader, $imageName, $override, Specification $specification = null)
    {
        // First modify image extension...
        $imageName = $this->setExtensionFromType($imageName, $imageUploader->type);

        if(! is_null($specification))

            return $this->uploadOne($imageUploader, $imageName, $override, $specification);

        return $this->uploadAll($imageUploader, $imageName, $override);
    }

    /**
     * @param $imageName
     * @param $type
     * @return string
     */
    protected function setExtensionFromType($imageName, $type)
    {
        $extension = pathinfo($imageName, PATHINFO_EXTENSION);

        // If extension is not already set..
        if($extension == '')
        {
            return $imageName . image_type_to_extension($type);
        }

        return $imageName;
    }

    /**
     * @param ImageUploader $imageUploader
     * @param $imageName
     * @param bool $override
     * @param Specification $specification
     * @throws \Exception
     *
     * @return Version
     */
    protected function uploadOne(ImageUploader $imageUploader, $imageName, $override, Specification $specification)
    {
        $uri = $specification->getPath( $imageName );

        $destination = $this->path->make((string) $this->path . '\\' . $uri);

        // Make this destination unique if override is set to false
        if(! $override) $destination->makeUnique();

        $destination->makeSureItExists();

        // Evaluate code on the image uploader then save it to the destination
        if($code = $specification->code)

            $imageUploader = $code->evaluate(array('image' => $imageUploader));

        if(! $imageUploader instanceof ImageUploader)

            throw new \Exception("The code you entered for group specification didn't return an image.");

        $imageUploader->save((string) $destination);

        return $this->versions->newInstance(array(
            'width'  => $imageUploader->width,
            'height' => $imageUploader->height,
            'url'    => $destination->toUrl()
        ));
    }

    /**
     * @param ImageUploader $imageUploader
     * @param $imageName
     * @param bool $override
     *
     * @return Version[]
     */
    protected function uploadAll(ImageUploader $imageUploader, $imageName, $override)
    {
        $versions = array();

        foreach($this->group->getSpecs() as $specification)
        {
            $versions[] = $this->uploadOne(clone $imageUploader, $imageName, $override, $specification);
        }

        return $versions;
    }
}