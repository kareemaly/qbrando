<?php namespace Kareem3d\Eloquent;

use Illuminate\Database\Query\Builder;

abstract class Algorithm {

    /**
     * @var Builder
     */
    protected $query = null;

    /**
     * @return Algorithm
     */
    public function __construct()
    {
        $this->query = $this->emptyQuery();
    }

    /**
     * @param string $order
     * @return $this
     */
    public function orderByDate( $order = 'desc' )
    {
        $this->getQuery()->orderBy('created_at', $order);

        return $this;
    }

    /**
     * @param Builder $query
     * @return $this
     */
    public function setQuery( $query )
    {
        $this->query = $query;

        return $this;
    }

    /**
     * @return Builder
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @return void
     */
    public function reset()
    {
        $this->query = $this->emptyQuery();
    }

    /**
     * @param bool $reset
     * @return int
     */
    public function count( $reset = true )
    {
        $count = $this->getQuery()->count();

        if($reset) $this->reset();

        return $count;
    }

    /**
     * @param int $perPage
     * @param array $columns
     * @param bool $reset
     * @return \Illuminate\Pagination\Paginator
     */
    public function paginate($perPage = 15, $columns = array('*'), $reset = true)
    {
        $paginator = $this->getQuery()->paginate($perPage, $columns);

        if($reset) $this->reset();

        return $paginator;
    }

    /**
     * @param array $columns
     * @param bool $reset
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function get(array $columns = array('*'), $reset = true)
    {
        $collection = $this->getQuery()->get($columns);

        if($reset) $this->reset();

        return $collection;
    }

    /**
     * @param array $columns
     * @param bool $reset
     * @return mixed
     */
    public function first(array $columns = array('*'), $reset = true)
    {
        $model = $this->getQuery()->first($columns);

        if($reset) $this->reset();

        return $model;
    }

    /**
     * @param $num
     * @return \Illuminate\Database\Query\Builder|static
     */
    public function take($num)
    {
        return $this->getQuery()->take($num);
    }

    /**
     * Easy way to use many methods in the concrete class.
     * <code>
     * $algorithm->call('popular', array('year', 2013), array('month', 3));
     * </code>
     *
     * @return $this
     */
    public function call()
    {
        // Get arguments
        $args = func_get_args();

        // Loop through all args which represents methods
        foreach ($args as $method)
        {
            // If method is string then call method if exists and hold the current query.
            if(is_string($method) && method_exists(get_called_class(), $method)) {

                call_user_func_array(array($this,$method), array());
            }

            // If is array it means he is passing parameters with the method.
            // $method = array('methodName', $param1, $param2, ... )
            else if(is_array($method)) {

                // Get function from array
                $func = array_shift($method);

                if(method_exists(get_called_class(), $func)) {
                    call_user_func_array(array($this, $func), $method);
                }
            }
        }

        return $this;
    }

    /**
     * @return static
     */
    public static function make()
    {
        return new static;
    }

    /**
     * @return Builder
     */
    public abstract function emptyQuery();
}