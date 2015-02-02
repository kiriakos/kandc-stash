<?php
/**
 * Helper class that defines the base characteristics of a component helper
 * 
 * A component helper isn't a component in itself, it has no dependencies
 * it just provides specialiyed funcitonality and can assume the context of the 
 * owner Component (viz. get a refference to it's owner). So context aware 
 * functionality is also provided.
 * 
 */
class ComponentHelper
{ 
    private $_c; 
    public final function __construct(Component $component)
    { 
        $this->_c = $component;
    }
    
    /**
     * 
     * @return Component
     */
    public function getComponent() 
    { 
        return $this->_c;
    }
}
