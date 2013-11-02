<?php namespace Kareem3d\Marketing;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Kareem3d\Eloquent\Model;
use Kareem3d\URL\URL;

class SEO extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'seo';

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
     * @param $value
     * @return mixed
     */
    public function setUrlAttribute( $value )
    {
        if(is_object($value) and
            get_class($value) == App::make('Kareem3d\URL\URL')->getClass())

            return $this->url()->save($value);

        $this->url()->associate(App::make('Kareem3d\URL\URL')->create(array('url' => $value)));
    }

    /**
     * @return string
     */
    public function toHtml()
    {
        return View::make('marketing::head', array('seo' => $this))->render();
    }

    /**
     * @param $inputs
     * @return SEO|null
     */
    public static function createOrUpdate( $inputs )
    {
        if(! isset($inputs['url_id'])) return null;

        if($seo = static::getByUrlId($inputs['url_id']))
        {
            $seo->update($inputs);

            return $seo;
        }
        else
        {
            return static::create($inputs);
        }
    }

    /**
     * @return SEO|null
     */
    public static function getCurrent()
    {
        // Get current url and get the seo linked to it
        if($url = App::make('Kareem3d\URL\URL')->getCurrent())

            return static::getByUrl($url);
    }

    /**
     * @param URL $url
     * @return SEO
     */
    public static function getByUrl( URL $url )
    {
        return static::getByUrlId($url->id);
    }

    /**
     * @param $id
     * @return SEO
     */
    public static function getByUrlId( $id )
    {
        return static::where('url_id', $id)->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function url()
    {
        return $this->belongsTo(App::make('Kareem3d\URL\URL')->getClass());
    }
}