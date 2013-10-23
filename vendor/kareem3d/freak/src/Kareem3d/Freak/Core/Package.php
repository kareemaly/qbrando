<?php namespace Kareem3d\Freak\Core;

abstract class Package implements PackageInterface {

    /**
     * @var PackageData[]
     */
    protected $data = array();

    /**
     * @param $name
     * @return bool|string
     */
    public function checkName( $name )
    {
        return strtolower($this->getName()) === strtolower($name);
    }

    /**
     * @param PackageData $data
     */
    public function addData(PackageData $data)
    {
        $this->data[] = $data;
    }

    /**
     * @param PackageData[] $data
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return PackageData|null
     */
    protected function getElementData()
    {
        foreach($this->data as $packageData)
        {
            if($packageData->fromElement())

                return $packageData;
        }
    }

    /**
     * @param $package
     * @return PackageData
     */
    protected function getPackageData( $package )
    {
        foreach($this->data as $packageData)
        {
            if($packageData->fromPackage($package))

                return $packageData;
        }
    }

    /**
     * @param $key
     * @param string $default
     * @return string
     */
    protected function getExtra( $key, $default = '' )
    {
        foreach($this->data as $packageData)
        {
            if($packageData->hasExtra($key))

                return $packageData->getExtra($key);
        }

        return $default;
    }

    /**
     * @param $key
     * @return string
     * @throws \Exception
     */
    protected function getExtraRequired( $key )
    {
        if(! $value = $this->getExtra( $key ))

            throw new \Exception("The extra {$key} is required for {$this->getName()} package");

        return $value;
    }
}