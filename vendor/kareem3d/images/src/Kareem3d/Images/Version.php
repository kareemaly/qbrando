<?php namespace Kareem3d\Images;

use Kareem3d\Eloquent\Model;
use PathManager\Path;
use PathManager\PathException;

class Version extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'versions';

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
        'image_id' => 'required|exists:images,id',
        'url'      => 'required|url',
        'width'    => 'required|integer',
        'height'   => 'required|integer'
    );

    /**
     * For factoryMuff package to be able to fill attributes.
     *
     * @var array
     */
    public static $factory = array(
        'url'      => 'http://fbcdn-profile-a.akamaihd.net/hprofile-ak-ash4/187793_431846433497472_1192504853_q.jpg',
        'width'    => 50,
        'image_id' => 'factory|Gallery\Image\Image',
        'height'   => 50
    );

    /**
     * Generate version dimensions.
     *
     * @param  string $url
     * @return Version|null
     */
    public static function generate( $url )
    {
        if(! $imageInfo = @getimagesize($url)) return null;

        return new Version(array(
            'url'    => $url,
            'width'  => $imageInfo[0],
            'height' => $imageInfo[1],
        ));
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Get image for this image.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function image()
    {
        return $this->belongsTo( 'Kareem3d\Images\Image' );
    }

    /**
     * @return bool
     */
    public function delete()
    {
        try{
            $path = Path::make($this->url);

            $path->delete();
        }catch(PathException $e){}

        return parent::delete();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->url;
    }
}