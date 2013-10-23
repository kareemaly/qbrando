<?php namespace Kareem3d\Ecommerce;

use Illuminate\Support\Facades\App;
use Kareem3d\Eloquent\Model;

class Category extends Model {

    /**
     * @var string
     */
    protected $table = 'categories';

    /**
     * @var array
     */
    protected $guarded = array();

    /**
     * @var array
     */
    protected $rules = array(
        'title' => 'required'
    );

    /**
     * @var array
     */
    protected static $dontDuplicate = array('title');

    /**
     * @var string
     */
    protected static $specsTable = 'category_specs';

    /**
     * @var array
     */
    protected static $specs = array('title');

    /**
     * @param $title
     * @return mixed
     */
    public static function getByTitle( $title )
    {
        return static::allSpecsQuery()->where('title', $title)->first();
    }

    /**
     * @return bool
     */
    public function hasProducts()
    {
        return $this->products()->count() > 0;
    }

    /**
     * @return bool
     */
    public function hasParent()
    {
        return $this->parent->count() > 0;
    }

    /**
     * @return bool
     */
    public function hasChildren()
    {
        return $this->children()->count() > 0;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(App::make('Kareem3d\Ecommerce\Category')->getClass());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(App::make('Kareem3d\Ecommerce\Category')->getClass());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->hasMany(App::make('Kareem3d\Ecommerce\Product')->getClass());
    }

    /**
     * @return mixed|string
     */
    public function __toString()
    {
        return $this->title;
    }
}