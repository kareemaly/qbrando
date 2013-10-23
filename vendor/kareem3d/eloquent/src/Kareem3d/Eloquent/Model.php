<?php namespace Kareem3d\Eloquent;

use Helper\Helper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

abstract class Model extends \Illuminate\Database\Eloquent\Model {

    /**
     * @var array
     */
    protected $guarded = array();

    /**
     * @var array
     */
    protected static $registeredExtensions = array();

    /**
     * To solve PHP 5.3 no trait issue
     *
     * @var array
     */
    protected $extensions = array();

    /**
     * Validation rules
     *
     * @var array
     */
    protected $rules = array();

    /**
     * Validation custom messages
     *
     * @var array
     */
    protected $customMessages = array();

    /**
     * @var \Illuminate\Validation\Validator
     */
    protected $validator = null;

    /**
     * array('email', 'username') => Won't duplicate if ONE of them is the same
     * array(array('email', 'username')) => Won't duplicate if BOTH of them are the same
     *
     * @var array
     */
    protected static $dontDuplicate = array();

    /**
     * @var null
     */
    protected static $specsTable = null;

    /**
     * @var array
     */
    protected static $specs = array();

    /**
     * @var array
     */
    public static $languages = array('en');

    /**
     * @var string
     */
    public static $defaultLanguage = 'en';

    /**
     * @var array
     */
    protected $languagesAttributes = array();

    /**
     * @param $id
     * @param array $columns
     * @return \Kareem3d\Eloquent\Model
     */
    public static function findOrNew($id, $columns = array('*'))
    {
        if($model = static::find($id, $columns))

            return $model;

        return new static;
    }

    /**
     * @param $name
     * @param $class
     */
    public static function registerExtension( $name, $class )
    {
        static::$registeredExtensions[ $name ] = $class;
    }

    /**
     * We are giving all system the ability to clean it's attributes from XSS attack.
     *
     * @return void
     */
    public function cleanXSS()
    {
        Helper::instance()->cleanXSS($this->getAttributes());
    }

    /**
     * @return\Illuminate\Support\MessageBag
     */
    public function getValidatorMessages()
    {
        return $this->getValidator()->messages();
    }

    /**
     * @param $rule
     */
    public function escapeRule( $rule )
    {
        unset($this->rules[ $rule ]);
    }

    /**
     * This method will check if the given attributes are valid or not..
     * Remember that there is a validator object that holds the last validation.
     *
     * @return bool
     */
    public function isValid()
    {
        return $this->getValidator()->passes();
    }

    /**
     * @return void
     */
    public function resetValidator()
    {
        $this->validator = null;
    }

    /**
     * @param  string $name
     * @return void
     */
    public function validatePolymorphic( $name )
    {
        $type = $name . '_type';
        $id   = $name . '_id';

        // Add rules in the validations
        $this->rules[$type] = 'required';

        // Add custom messages
        $customMessage = 'No model is attached to this model.';
        $this->customMessages[$type . '.required'] = $this->getAttribute($type) . ',' . $customMessage;
        $this->customMessages[$id   . '.required'] = $customMessage;
        $this->customMessages[$id   . '.exists']   = $customMessage;

        $related = $this->getAttribute($type);

        // Check if class exists.
        if(class_exists($related)) {

            $model = new $related();

            $this->rules[$id] = 'required|exists:' . $model->getTable() . ',id';
        } else {

            // If type class doesn't exists then clear it to fail in the validation step.
            $this->setAttribute($type, '');
        }
    }

    /**
     * This method holds the state of the last validator
     * If null then it will validate with the current model attributes.
     *
     * @return \Illuminate\Validation\Validator
     */
    public function getValidator()
    {
        if($this->validator) return $this->validator;

        // Search for polymorphic relationship to be validated
        if($key = array_search('polymorphic', $this->rules)) {

            $this->validatePolymorphic( $key );
        }

        $this->validator = Validator::make($this->getAttributes(), $this->rules, $this->customMessages);

        return $this->validator;
    }

    /**
     * Each time this method is called the model is validated from all over again.
     *
     * @return bool
     */
    public function validate()
    {
        if($this->beforeValidate() === false) return false;

        // Will reset validator to validate the model again
        $this->resetValidator();

        if($this->getValidator()->passes()) {

            return true;
        }

        return false;
    }

    /**
     * @param array $attributes
     * @return \Illuminate\Validation\Validator
     */
    public static function validateAttributes(array $attributes)
    {
        $instance = static::newInstance($attributes);

        return $instance->getValidtor();
    }

    /**
     * This will validate the model and save it.
     *
     * @param array $attributes
     * @return Model
     */
    public static function create( array $attributes )
    {
        $model = new static($attributes);

        $model->save();

        return $model;
    }

    /**
     * This will validate the model and save it.
     *
     * @param array $options
     * @return bool
     */
    public function save(array $options = array())
    {
        // Check before save method
        if($this->beforeSave() === false) return false;

        // First check if there's a duplicate for this model to update it.
        if($duplicateModel = $this->getDuplicate())
        {
            $this->exists = true;
            $this->id     = $duplicateModel->id;
        }

        // If this has specs table
        if($this->hasSpecsTable())
        {
            $specsAttrs = $this->extractSpecsAttributes();

            if(parent::save($options))

                return $this->setSpecsTableRow( $specsAttrs );

            return false;
        }

        return parent::save($options);
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function getAttribute($key)
    {
        if($value = parent::getAttribute($key)) return $value;

        // If this has specs table
        if($this->hasSpecsTable())
        {
            // If the key is in the specifications array then get this attribute by default language.
            if(in_array($key, static::$specs))
            {
                return $this->getAttributeByLanguage($key, static::$defaultLanguage);
            }
        }
    }

    /**
     * @param array|string $key
     * @param $language
     * @return array|string
     */
    public function getAttributeByLanguage( $key, $language )
    {
        // First make sure we are using this language
        if(! $this->isUsingLanguage( $language ))
        {
            $this->useLanguage( $language );
        }

        return isset($this->languagesAttributes[$language][$key]) ? $this->languagesAttributes[$language][$key] : null;
    }

    /**
     * @param $language
     * @return bool
     */
    protected function isUsingLanguage( $language )
    {
        return isset($this->languagesAttributes[$language]);
    }

    /**
     * @param $language
     * @return void
     */
    public function useLanguage( $language )
    {
        $array = (array) $this->getSpecsQuery($language)->first(static::$specs);

        if(! empty($array)) $this->languagesAttributes[ $language ] = $array;
    }

    /**
     * @return void
     */
    public function useDefaultLanguage()
    {
        $this->useLanguage( static::$defaultLanguage );
    }

    /**
     * @return Builder
     */
    public static function allSpecsQuery()
    {
        return DB::table(static::$specsTable);
    }

    /**
     * @return null
     */
    public static function getSpecsTable()
    {
        return static::$specsTable;
    }

    /**
     * @param string $language
     * @return mixed
     */
    public function getSpecsQuery( $language = '' )
    {
        $query =  DB::table(static::$specsTable)->where($this->getForeignKey(), $this->id);

        if($language) return $query->where('language', $language);

        return $query;
    }

    /**
     * @return bool
     */
    protected function hasSpecsTable()
    {
        return static::$specsTable != null;
    }

    /**
     * Return current language.
     *
     * @return string
     */
    protected function getCurrentLanguage()
    {
        return $this->language ?: static::$defaultLanguage;
    }

    /**
     * @return mixed
     */
    public static function specsQuery()
    {
        $model = new static;

        $query = $model->newQuery();

        $specsTable = static::getSpecsTable();

        return $query->join($specsTable, "{$model->getTable()}.{$model->getKeyName()}", '=', "$specsTable.{$model->getForeignKey()}");
    }

    /**
     * @param array $specsAttrs
     * @return mixed
     */
    protected function setSpecsTableRow( array $specsAttrs )
    {
        $query = $this->getSpecsQuery($specsAttrs['language']);

        $spec = $query->first();

        if($spec == null)
        {
            $specsAttrs[$this->getForeignKey()] = $this->id;

            return DB::table(static::$specsTable)->insert($specsAttrs);
        }
        else
        {
            return $query->update($specsAttrs);
        }
    }

    /**
     * @return array
     */
    protected function extractSpecsAttributes()
    {
        $attrs = array();

        $specsAttrs = static::$specs;

        array_push($specsAttrs, 'language');

        $this->attributes['language'] = $this->getCurrentLanguage();

        foreach($specsAttrs as $specification)
        {
            if(isset($this->attributes[ $specification ]))
            {
                $attrs[ $specification ] = $this->attributes[ $specification ];

                unset($this->attributes[ $specification ]);
            }
        }

        return $attrs;
    }

    /**
     * Return duplicate model if exists.
     *
     * @return \Kareem3d\Eloquent\Model|null
     */
    public function getDuplicate()
    {
        if(empty(static::$dontDuplicate)) return null;

        if($this->hasSpecsTable())
        {
            $query = DB::table(static::$specsTable);
        }
        else
        {
            $query = $this->newQuery();
        }

        return $query->where('id', '!=', (int) $this->id)->where(function($query)
        {
            foreach(static::$dontDuplicate as $attribute)
            {
                if(is_array($attribute))
                {
                    $query->orWhere(function($query) use ($attribute)
                    {
                        foreach($attribute as $andAttr)
                        {
                            $query->where($andAttr, $this->getAttribute($andAttr));
                        }
                    });
                }
                else
                {
                    $query->orWhere($attribute, $this->getAttribute($attribute));
                }
            }
        })->first();
    }

    /**
     * Before validate event..
     *
     * @return mixed
     */
    public function beforeValidate()
    {
        $this->useMethodIfExists('beforeValidate');
    }

    /**
     * Before save event..
     *
     * @return mixed
     */
    public function beforeSave()
    {
        $this->useMethodIfExists('beforeSave');
    }

    /**
     * @param string $format
     * @return string
     */
    public function getCreatedAt( $format = '' )
    {
        $created_at = $this->getAttribute('created_at');

        if(! $format) return $created_at;

        else return date($format, strtotime($created_at));
    }

    /**
     * @param $method
     * @return null
     */
    protected function getExtensionObjectFromMethod($method)
    {
        foreach($this->extensions as $extension)
        {
            $className = $this->getExtensionClass($extension);

            if(! class_exists($className)) continue;

            $object = new $className( $this );

            if(method_exists($object, $method)) return $object;
        }

        return null;
    }

    /**
     * @param $method
     * @return mixed|null
     */
    protected function useMethodIfExists($method)
    {
        if($this->usesMethod($method))
        {
            return $this->useMethod($method, array());
        }

        return null;
    }

    /**
     * @param  string $method
     * @return bool
     */
    protected function usesMethod($method)
    {
        return $this->getExtensionObjectFromMethod($method) != null;
    }

    /**
     * @param $method
     * @param $parameters
     * @return mixed
     */
    protected function useMethod($method, $parameters)
    {
        $object = $this->getExtensionObjectFromMethod($method);

        return call_user_func_array(array($object, $method), $parameters);
    }

    /**
     * @param $class
     * @return bool
     */
    public function doesUse( $class )
    {
        return array_search($class, $this->extensions) !== false;
    }

    /**
     * @param array $models
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function newCollection(array $models = array())
    {
        foreach($this->extensions as $extension)
        {
            if(method_exists($this->getExtensionClass($extension), 'newCollection'))

                return call_user_func($this->getExtensionClass($extension) . '::newCollection', $models);
        }

        return new Collection($models);
    }

    /**
     * @param string $name
     * @return string
     */
    protected function getExtensionClass( $name )
    {
        return static::$registeredExtensions[ $name ];
    }

    /**
     * @param Model $model
     * @return bool
     */
    public function same( Model $model )
    {
        return ($model->id == $this->id);
    }

    /**
     * Using extensions
     *
     * @param string $method
     * @param array $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if(in_array($method, static::$languages) && isset($parameters[0]))
        {
            return $this->getAttributeByLanguage($parameters[0], $method);
        }

        if($this->usesMethod($method))
        {
            return $this->useMethod($method, $parameters);
        }

        return parent::__call($method, $parameters);
    }

    /**
     * @return string
     */
    public static function getClass()
    {
        return get_called_class();
    }

    /**
     * @param $value
     */
    public static function encrypt( $value )
    {
        return Crypt::encrypt( $value );
    }

    /**
     * @param $value
     * @return string
     */
    public static function decrypt( $value )
    {
        return Crypt::decrypt( $value );
    }

    /**
     * Get all rows newer than the given date
     *
     * @param mixed $date
     * @return Collection
     */
    public static function getNewerThan($date)
    {
        $instance = new static;

        return $instance->where($instance->getCreatedAtColumn(), '>', $date)->get();
    }
}