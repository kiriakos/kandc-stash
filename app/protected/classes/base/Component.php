<?php

include_once dirname(__FILE__). "/". "ComponentBase.php";
include_once dirname(__FILE__). "/". "ComponentConfiguration.php";
include_once dirname(__FILE__). "/". "ComponentHelper.php";
include_once dirname(__FILE__). "/". "ComponentScopes.php";
include_once dirname(__FILE__). "/". "AliasTypes.php";
include_once dirname(__FILE__). "/". "PathTypes.php";
include_once dirname(__FILE__). "/". "DependencyManager.php";
include_once dirname(__FILE__). "/". "Inflector.php";
include_once dirname(__FILE__). "/". "PathManager.php";

/**
 * Base functionality of a component
 *
 * deals also with dependency injection by reading dependencies out of the 
 * Component's config file and loading them thorugh Knc::getComponent()
 * 
 * Components are to be seen similar to Java EE beans. Even though they don't 
 * have context information atm the provide argument free constructors and
 * setters that follow the EJB spec
 * 
 * @author kiriakos
 */
abstract class Component 
extends ComponentBase
{   
    /**
     * 
     * @return \ComponentConfiguration
     */
    public function getComponentConfiguration()
    {
        return new ComponentConfiguration(
                $this->getPathManager()->getConfigFilePath());
    }
    
    /**
     * Magic method that provides Dependency retrieval.
     * 
     * TODO: create a way for dependencies to know their dependants. Also allow
     *       for strategies on dependants. eg: only on dependant of type X oder 
     *       interface IX
     * 
     * @param string $method
     * @param array $arguments
     * @return mixed
     */
    public function __call($method, $arguments = NULL) 
    {
        if($this->getInflector()->isGetterMethod($method))
        {
            $component = $this->getInflector()->getComponentNameFromGetter($method);
            if($this->getDM()->hasDependencyWithName($component))
            {
                $dependency = $this->getDM()->getDependencyByName($component);
                $dependency->setCaller($this);
                return $dependency;
            }
        }
        
        throw new BadMethodCallException("This instance of ". get_called_class()
                . " does not implement the method: '$method'!");
    }
    
    /**
     * Set the attributes of an object based on existing setters
     * 
     * @param array $attributes
     */
    public function setAttributes($attributes)
    {
        foreach($attributes as $attr => $value)
        {   $setter = 'set'. ucfirst($attr);
            if(method_exists($this, $setter))
            {
                call_user_func(array($this, $setter), $value);
            }
        }
    }
}