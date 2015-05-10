<?php
/**
 * The base test case
 *
 * 
 * @author kiriakos
 */
abstract class KncTestCase
extends PHPUnit_Framework_TestCase
{
    private $_component;
    private $_app;
    
    /**
     * @return string   The dottedname of the alias
     */
    abstract function getComponentAlias();
        
    /**
     * 
     * @return Component
     */
    public function getComponent()
    {
        if($this->_component === NULL)        
        {
            if($this->getInterface())
            {
                $this->getApp()->getPathManager()
                        ->importInterface($this->getInterface());
            }
            
            $this->getApp()->getPathManager()->importClass($this->getComponentAlias());
            $class = array_pop(explode('.', $this->getComponentAlias()));
            $this->_component = new $class($this->getComponentAlias());
        }
        
        return $this->_component;
    }
        
    /**
     * @return Knc
     */
    public function getApp()
    {
        if($this->_app === NULL)
        {
            $this->_app = Knc::get();
        }
        
        return $this->_app;
    }
    
    /**
     * This method is a stopgap to allow for interface inclusion at a time 
     * when the KnC container cannot define the location of a component 
     * interface. This will change when namespacing is included making the 
     * feature obsolete.
     * 
     * @deprecated since version 0.5
     * @return NULL
     */
    public function getInterface()
    {}
}

class MockComponent
extends Component
{
    
}
