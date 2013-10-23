<?php namespace Kareem3d\Images;

use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Intervention\Image\Image as ImageUploader;

class ImageFacade {

    /**
     * @var UploadedFile
     */
    protected $file;

    /**
     * @var Group
     */
    protected $group;

    /**
     * @var ImageManager
     */
    protected $imageManager;

    /**
     * @param UploadedFile $file
     * @param \Kareem3d\Images\Group $group
     */
    public function __construct(UploadedFile $file, Group $group)
    {
        $this->file = $file;
        $this->group = $group;
    }

    /**
     * @return bool
     */
    public function validate()
    {
        $imageTypes = array (
            IMAGETYPE_GIF,
            IMAGETYPE_JPEG,
            IMAGETYPE_PNG,
            IMAGETYPE_SWF,
            IMAGETYPE_PSD,
            IMAGETYPE_BMP,
            IMAGETYPE_TIFF_II,
            IMAGETYPE_TIFF_MM,
            IMAGETYPE_JPC,
            IMAGETYPE_JP2,
            IMAGETYPE_JPX,
            IMAGETYPE_JB2,
            IMAGETYPE_SWC,
            IMAGETYPE_IFF,
            IMAGETYPE_WBMP,
            IMAGETYPE_XBM,
            IMAGETYPE_ICO
        );

        foreach($imageTypes as $imageType)
        {
            try{
                if($this->file->getMimeType() == image_type_to_mime_type ($imageType))
                {
                    return true;
                }
            }catch(\Exception $e){ return false; }
        }

        return false;
    }

    /**
     * Quick factory method to create upload images and get versions
     *
     * @param string $groupName
     * @param string $imageName
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
     * @param bool $override
     * @param \Intervention\Image\Image $imageUploader
     *
     * @return \Kareem3d\Images\Version[]
     */
    public static function versions($groupName, $imageName, UploadedFile $file, $override = true, ImageUploader $imageUploader = null)
    {
        $image = App::make('\Kareem3d\Images\ImageFacade', $file);

        return $image->upload($groupName, $imageName, $override, $imageUploader);
    }

    /**
     * @param UploadedFile $file
     */
    public function setFile( UploadedFile $file )
    {
        $this->file = $file;
    }

    /**
     * @param Group $group
     */
    public function setGroup(Group $group)
    {
        $this->group = $group;
    }

    /**
     * @return Group
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @return \Kareem3d\Images\ImageManager
     */
    public function getImageManager()
    {
        return $this->imageManager;
    }

    /**
     * @param \Kareem3d\Images\ImageManager $imageManager
     */
    public function setImageManager(ImageManager $imageManager)
    {
        $this->imageManager = $imageManager;
    }

    /**
     * @param $name
     * @return Group
     */
    public function getGroupByName( $name )
    {
        return $this->getGroup()->getByName($name);
    }

    /**
     * @return ImageUploader
     */
    public function makeUploader()
    {
        return ImageUploader::make($this->file->getRealPath());
    }

    /**
     * @param string $groupName
     * @param string $imageName
     * @param bool $override
     * @param \Intervention\Image\Image $imageUploader
     * @throws \Exception
     * @return \Kareem3d\Images\Version[]|bool
     */
    public function upload( $groupName, $imageName, $override = true, ImageUploader $imageUploader = null )
    {
        if(! $this->validate()) return false;

        if(! $imageUploader) $imageUploader = $this->makeUploader();

        // Get group by name
        if(! $group = $this->getGroupByName($groupName)) throw new \Exception("Group you specified doesn't exist.");

        // Uploading image with given group specifications...
        $imageManager = App::make('\Kareem3d\Images\ImageManager', $group);

        return $imageManager->upload($imageUploader, $imageName, $override);
    }
}