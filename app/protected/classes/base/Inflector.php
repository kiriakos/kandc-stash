<?php

class Inflector
extends ComponentHelper
{   
    /**
     * @param string $method_name
     * @return boolean
     */
    public function isSetterMethod($method_name)
    {
        return (bool) preg_match('/^set/', $method_name);
    }
    
    /**
     * @param string $method_name
     * @return boolean
     */
    public function isGetterMethod($method_name)
    {
        return (bool) preg_match('/^get/', $method_name);
    }
    
    
    /**
     * @param string $method_name
     * @return string
     */
    public function getComponentNameFromGetter($method_name)
    {
        return preg_replace('/^get/', '', $method_name);
    }
    
    public function getSetterMethod($attribute)
    {
        throw new Exception('Not implemented. Yet!');
    }
}
