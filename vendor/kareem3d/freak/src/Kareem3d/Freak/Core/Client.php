<?php namespace Kareem3d\Freak\Core;

abstract class Client implements ClientInterface {

    /**
     * @param $name
     * @return string|void
     */
    public function checkName( $name )
    {
        return strtolower($this->getName()) == $name;
    }

    /**
     * @param array $elements
     * @param $elementName
     * @param Package $package
     */
    protected function usePackage( array $elements, $elementName, Package $package )
    {
        if($element = $this->getElementByName($elements, $elementName))
        {
            $element->addPackage($package);
        }
    }

    /**
     * @param Element[] $elements
     * @param $name
     * @return Element|null
     */
    protected function getElementByName( $elements, $name )
    {
        foreach($elements as $element)
        {
            if($element->checkName( $name ))

                return $element;
        }
    }

    /**
     * @param Element[] $elements
     * @param $name
     * @param \Closure $closure
     * @return mixed
     */
    protected function modifyElement( array $elements, $name, \Closure $closure )
    {
        if($element = $this->getElementByName($elements, $name))
        {
            call_user_func_array($closure, array($element));
        }
    }

    /**
     * @return array
     */
    protected function generateElements()
    {
        $names = func_get_args();

        $elements = array();

        foreach($names as $name)
        {
            $element = new Element($name);

            $elements[] = $element->useDefaults();
        }

        return $elements;
    }

}