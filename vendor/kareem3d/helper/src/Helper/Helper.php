<?php namespace Helper;

class Helper {

	/** 
	 * Helper instnace.
	 *
	 * @var Helper
	 */
	protected static $instance;

	/**
	 * Singleton implementation
	 *
	 * @return void
	 */
	private function __construct(){}

	/**
	 * Singleton instance.
	 *
	 * @return Helper
	 */
	public static function instance()
	{
		if(! static::$instance)

			static::$instance = new static;

		return static::$instance;
	}

	/**
	 * Strip tags of all array values
	 *
	 * @param  array $inputs
	 * @return array
	 */
	public function cleanXSS( $inputs )
	{
		array_walk($inputs, function( &$input )
		{
			$input = strip_tags($input);
		});
	}

	/**
	 * Get keys from the given inputs array
	 *
	 * @param  array $inputs
	 * @param  array $keys
	 * @return array
	 */
	public function arrayGetKeys( $inputs, $keys )
	{
		$newInputs = array();
		
		foreach ($inputs as $key => $value) {

			if(in_array($key, $keys))

				$newInputs[ $key ] = $value;
		}

		return $newInputs;
	}

	/**
	 * Replace all replacers from string
	 * 
	 * @param  string $string
	 * @param  array  $replacers
	 * @return string
	 */
	public function replaceAll( $string, $replacers )
	{
		foreach ($replacers as $key => $value)
		{
			$string = str_replace('{' . $key . '}', $value, $string);
		}

		return $string;
	}

    /**
     * Determine if two associative arrays are similar
     *
     * Both arrays must have the same indexes with identical values
     * without respect to key ordering
     *
     * @param array $a
     * @param array $b
     * @return bool
     */
    public function similarArrays(array $a, array $b)
    {
        // if the indexes don't match, return immediately
        if (count(array_diff_assoc($a, $b))) {
            return false;
        }
        // we know that the indexes, but maybe not values, match.
        // compare the values between the two arrays
        foreach($a as $k => $v) {
            if ($v !== $b[$k]) {
                return false;
            }
        }
        // we have identical indexes, and no unequal values
        return true;
    }


    /**
     * Get Client IP.
     *
     * @return string
     */
    public function getCurrentIP()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) //if from shared
        {
            return $_SERVER['HTTP_CLIENT_IP'];
        }
        else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //if from a proxy
        {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else if (!empty($_SERVER['REMOTE_ADDR']))
        {
            return $_SERVER['REMOTE_ADDR'];
        }

        return '127.0.0.1';
    }
}