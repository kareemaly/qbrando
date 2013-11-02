<?php namespace Kareem3d\URL;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Request;
use Kareem3d\Eloquent\Model;

class URL extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'urls';

    /**
     * @var array
     */
    protected static $dontDuplicate = array(array('uri', 'domain'));

    /**
     * @var URL|null
     */
    protected static $currentUrl = null;

    /**
     * @return string
     */
    public static function getCurrentUri()
    {
        return urldecode(Request::path());
    }

    /**
     * @return mixed
     */
    public static function getCurrentDomain()
    {
        return Request::server('SERVER_NAME');
    }

    /**
     * @param $url
     * @return \Kareem3d\URL\URL
     */
    public static function getByUrl( $url )
    {
        $url = parse_url($url);

        return static::getByUriAndDomain($url['path'], $url['host']);
    }

    /**
     * @return URL
     */
    public static function getCurrent()
    {
        if(! static::$currentUrl)

            static::$currentUrl = static::getByUriAndDomain(static::getCurrentUri(), static::getCurrentDomain());

        return static::$currentUrl;
    }

    /**
     * @param $uri
     * @param $domain
     * @return URL
     */
    public static function getByUriAndDomain( $uri, $domain )
    {
        return static::where(function(Builder $query) use($uri)
        {
            $query->where('uri', $uri)->orWhere('uri', trim($uri, '/'));

        })->where(function(Builder $query) use($domain)
        {
            $query->where('domain', $domain)->orWhere('domain', '')->orWhere('domain', NULL);

        })->first();
    }

    /**
     * @param string $uri
     * @return bool
     */
    public static function isActive( $uri )
    {
        if(filter_var($uri, FILTER_VALIDATE_URL)) {

            return static::getCurrent()->saveUrl( $uri );
        }

        return static::getCurrent()->sameUri( $uri );
    }

    /**
     * @param $uri
     * @return bool
     */
    public function sameUrl( $url )
    {
        $url = parse_url($url);

        return $this->domain == $url['host'] && $this->sameUri($url['path']);
    }

    /**
     * @param $uri
     * @return bool
     */
    public function sameUri( $uri )
    {
        return trim($this->uri, '/') == trim($uri, '/');
    }

    /**
     * @param $url
     * @return void
     */
    public function setUrlAttribute( $url )
    {
        $url = parse_url($url);

        $this->uri = $url['path'];
        $this->domain = $url['host'];
    }

    /**
     * @param $uri
     * @return void
     */
    public function setUriAttribute( $uri )
    {
        $this->attributes['uri'] = trim($uri, '/');
    }

    /**
     * @param $domain
     * @return void
     */
    public function setDomainAttribute( $domain )
    {
        if($domain == static::getCurrentDomain()) return;

        $this->attributes['domain'] = $domain;
    }

    /**
     * Get full url => $domain.'/'.$uri
     *
     * @return string
     */
    public function getUrl()
    {
        if($this->domain)

            return rtrim($this->domain, '/') . '/' . ltrim($this->uri, '/');

        return rtrim(static::getCurrentDomain(), '/') . '/' . ltrim($this->uri, '/');
    }

    /**
     * @return bool
     */
    public function hasDomain()
    {
        return $this->domain != null;
    }

    /**
     * @return mixed|string
     */
    public function __toString()
    {
        return $this->getUrl();
    }
}