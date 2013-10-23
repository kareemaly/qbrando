<?php 

class Template {

    /**
     * @var array
     */
    protected $locations = array();

    /**
     * @var array
     */
    protected $parts;

    /**
     * @param array $parts
     */
    public function __construct( array $parts = array() )
    {
        $this->parts = $parts;
    }

    /**
     * @param $array
     * @return static
     */
    public static function factory( $array )
    {
        $parts = array();

        foreach($array as $part => $children)
        {
            if(! is_string($part) && is_string($children))
            {
                // This means the children = the part and there are no children
                $part = $children;
                $children = array();
            }

            $parts[] = Part::factory($part, $children);
        }

        return new static( $parts );
    }

    /**
     * @param $part
     * @param $location
     */
    public function setLocation( $part, $location )
    {
        $part = $this->findPart($part);

        $this->unsetLocation( $part );

        $this->locations[$location] = $part;
    }

    /**
     * @param Part $givenpart
     */
    public function unsetLocation( Part $givenpart )
    {
        foreach($this->locations as $location => $part)
        {
            if($part->same($givenpart))
            {
                unset($this->locations[$location]);

                break;
            }
        }
    }

    /**
     * @param $name
     * @return string
     */
    public function getLocation( $name )
    {
        foreach($this->locations as $location => $part)
        {
            if($part->check($name)) return $location;
        }
    }

    /**
     * @param $part
     * @param array $children
     * @param array $parameters
     */
    public function addPart($part, $children = array(), $parameters = array())
    {
        if($part instanceof Part)
        {
            $this->parts[] = $part;
        }

        else
        {
            $this->parts[] = Part::factory($part, $children, $parameters);
        }
    }

    /**
     * @param $parts
     * @param $arguments
     */
    public function body( $parts, $arguments )
    {

    }

    /**
     * @param string $name
     * @return string
     */
    public function render( $name )
    {
        if($part = $this->findPart( $name ))

            return $part->render();
    }

    /**
     * @param $name
     * @return Part
     */
    public function findPart( $name )
    {
        if($name instanceof Part) return $name;

        foreach($this->parts as $part)
        {
            if($part->check($name))

                return $part;
        }
    }

}