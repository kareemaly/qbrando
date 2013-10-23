<?php namespace Kareem3d\Images;

use Kareem3d\Eloquent\Model;

class Image extends Model {

    /**
     * @var array
     */
    protected $extensions = array('Polymorphic', 'Ordered');

    /**
     * @var string
     */
    public $polymorphicColumn = 'imageable';

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'images';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array();

	/**
	 * The attributes that can't be mass assigned
	 *
	 * @var array
	 */
    protected $guarded = array('id');

    /**
     * Whether or not to softDelete
     *
     * @var bool
     */
    protected $softDelete = false;

    /**
     * Validations rules
     *
     * @var array
     */
    protected $rules = array(
    );

    /**
     * For factoryMuff package to be able to fill attributes.
     *
     * @var array
     */
    public static $factory = array(
    );

    /**
     * @var VersionAlgorithm
     */
    protected $versionAlgorithm;

    /**
     * @param array $attributes
     * @param VersionAlgorithm $versionAlgorithm
     * @return Image
     */
    public function __construct(array $attributes = array(), VersionAlgorithm $versionAlgorithm = null)
    {
        parent::__construct($attributes);

        $this->versionAlgorithm = $versionAlgorithm ?: new VersionAlgorithm();
    }

    /**
     * @param int $width
     * @param int $height
     * @param bool $downSizing
     * @return string
     */
    public function html($width = 0, $height = 0, $downSizing = false)
    {
        if($width || $height)
        {
            $version = $this->getNearest( $width, $height, $downSizing );
        }
        else
        {
            $version = $this->getLargest();
        }

        return $version ? '<img src="' . $version->url .'" title="' . $this->getTitleTag() . '" alt="' . $this->getAltTag() . '" />' : '';
    }

    /**
     * @return string
     */
    public function getTitleTag()
    {
        return addslashes($this->title);
    }

    /**
     * @return string
     */
    public function getAltTag()
    {
        return addslashes($this->alt);
    }

    /**
     * @param VersionAlgorithm $versionAlgorithm
     */
    public function setVersionAlgorithm( VersionAlgorithm $versionAlgorithm )
    {
        $this->versionAlgorithm = $versionAlgorithm;
    }

    /**
     * @return VersionAlgorithm
     */
    public function getVersionAlgorithm()
    {
        return $this->versionAlgorithm;
    }

    /**
     * Determines if there's any version for this image
     *
     * @return boolean
     */
    public function exists()
    {
        return $this->versions()->count() > 0;
    }

    /**
     * Update image versions
     *
     * @param  array $versions
     * @return void
     */
    public function replace( $versions )
    {
        // Delete all versions first
        $this->versions()->delete();

        // Now upload all versions.
        $this->add( $versions );
    }

    /**
     * Add versions for this image.
     *
     * @param  array|Version $versions
     * @return Image
     */
    public function add( $versions )
    {
        return is_array($versions) ? $this->addMany( $versions ) : $this->addOne( $versions );
    }

    /**
     * Add one version
     *
     * @param \Kareem3d\Images\Version $version
     * @return Image
     */
    private function addOne( Version $version )
    {
        // Now save this version and attach it to this image.
        $this->versions()->save( $version );

        return $this;
    }

    /**
     * Add many versions.
     *
     * @param  array $versions
     * @return Image
     */
    private function addMany( array $versions )
    {
        foreach ($versions as $version)
        {
            $this->addOne($version);
        }

        return $this;
    }

    /**
     * Get url of the largest image by looping through all versions
     * and get the largest width and height.
     *
     * @return Version
     */
    public function getLargest()
    {
        return $this->getVersionAlgorithm()->largestDim()->byImage($this)->first();
    }

    /**
     * Get url of the smallest image by looping through all versions
     * and get the smallest width and height.
     *
     * @return Version
     */
    public function getSmallest()
    {
        return $this->getVersionAlgorithm()->smallestDim()->byImage($this)->first();
    }

    /**
     * Get version from given width and height by looping through all versions
     * and get the nearest one to the given width and height.
     *
     * @param  int $width
     * @param  int $height
     * @param bool $lowerSize
     * @return Version
     */
    public function getNearest( $width, $height, $lowerSize = false )
    {
        return $this->getVersionAlgorithm()->nearestDim($width, $height, $lowerSize)->byImage($this)->first();
    }

    /**
     * Delete image with deleting all it's versions
     *
     * @return void
     */
    public function delete()
    {
        foreach ($this->versions as $version)
        {
            $version->delete();
        }

        parent::delete();
    }

    /**
     * Get version array
     *
     * @return Query
     */
    public function versions()
    {
        return $this->hasMany('Kareem3d\Images\Version');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function imageable()
    {
        return $this->morphTo();
    }
}