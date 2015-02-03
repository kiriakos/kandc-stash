<?php
/**
 * Dependency manager
 * 
 * A dependency is a component that is descibed by an interface. The 
 * dependency's (working) name is determined by removing the I from the 
 * Interface name. A component can only depend on one interface name once.
 * 
 * A Working Name (wn) is an identifier that can be used to easily identify a
 * dependency. By default it is the name of the interface minus the "I", one
 * can though set a custom wn via the "working_name" configuration attribute
 * 
 */
class DependencyManager
extends ComponentHelper
{
    /**
     *  Component Instances for session and request Dependencies
     * 
     * Session holds session dependencies
     * Request hold request dependencies
     * 
     * @var array
     */
    private static $_dependencyPool = array(
        'request'   => array(),
        'session'   => array(),
        'instance' => array(),
    );
    
    /**
     *  List of dependency instances injected into the Component
     * 
     * indexes are interface aliases
     * 
     * @var array
     */
    private $_dependencies = array();
    
    /**
     *  List of dependency instances configured for the Component
     * 
     * indexes are interface aliases
     * 
     * @var array
     */
    private $_dependency_configuration = NULL;
    
    /**
     * Get a configured dependency.
     * 
     * @param string $alias
     * @return Component
     */
    public function getDependency($alias)
    {
        
        if(isset($this->_dependencies[$alias]))
        {            
            return $this->_dependencies[$alias];
        }
        elseif ($this->hasDependency($alias)) 
        {
            return $this->retrieveDependency($alias);
        }
        else
        {
            return NULL;
        }
    }
    
    private function retrieveDependency($alias)
    {
        foreach($this->getDependencyConfiguration() as
                $interface => $configuration)
        {
            if($alias === $interface)
            {
                return $this->injectDependency($interface, $configuration);
            }
        }
    }
        
    /**
     * get the Components dependency from  a Working Name
     * 
     * @param string $working_name
     * @return Component
     */
    public function getDependencyByName($working_name)
    {
        return $this->getDependency(
                $this->getDependencyAliasFromName($working_name));
    }
    
    /**
     * Checks the dependency config whether there is a dependency to this alias
     * 
     * @param string $alias
     * @return boolean
     */
    public function hasDependency($alias)
    {
        return isset($this->_dependency_configuration[$alias]);
    }
    
    
    /**
     * Searches the dependency configuration for a Working Name
     * 
     * @param string $working_name The Working Name to search for
     * @return boolean
     */
    public function hasDependencyWithName($working_name)
    {
        return ($this->getDependencyAliasFromName($working_name) !== NULL);
    }
    
    /**
     * Gets the Working Name of a dependency
     * 
     * adheres to custom configured Working Names through the "working_name"
     * attribute
     * 
     * @param string $alias
     * @return string
     */
    public function getDependencyWorkingName($alias)
    {
        $config = $this->_dependency_configuration[$alias];
        
        if(isset($config['working_name']) && $config['working_name'])
        {
            return $config['working_name'];
        }
        else
        {
            return preg_filter("/.*\.I/", '', $alias);
        }
    }
    
    /**
     * Get the dependency Alias from the passed working name
     * 
     * @param string $working_name  The Working Name to look for
     * @return string               The alias 
     */
    public function getDependencyAliasFromName($working_name)
    {
        foreach($this->_dependency_configuration as $alias => $config)
        {
            if($this->getDependencyWorkingName($alias) === $working_name)
            {
                return $alias;
            }
        }
        
        return NULL;
    }

    /**
     * Get the dependency information
     * 
     * Loads the Component Configuration from the configs folder (if there 
     * exists one) and if dependencies are configured returns them.
     * 
     * Dependencies are configured in an associative array with the dependency 
     * interface being the key and the class, scope and misc configuration being
     * a dict in the value part.
     * 
     * @return array;
     */
    public function getDependencyConfiguration()
    {
        if(!is_array($this->_dependency_configuration))
        {
            $this->_dependency_configuration = $this->getComponent()
                    ->getComponentConfiguration()
                    ->getDependencies();
        }
        return $this->_dependency_configuration;
    }
    
    /**
     * Retrieves the component's dependency configuration. 
     * 
     * also includes all required Interfaces
     */
    public function readDependencyConfiguration()
    {
        $pm = $this->getComponent()->getPathManager();
        
        foreach($this->getDependencyConfiguration() as $interface => $cfg)
        {
            $pm->importInterface($interface);
        }
    }
    
    /**
     * Adds Components to the Component's dependency list
     */
    public function injectDependencies()
    {
        foreach($this->getDependencyConfiguration() as
                $interface => $configuration)
        {
            $this->injectDependency($interface, $configuration);
        }
    }
    
    /**
     * 
     * @param string $interface     The alias of the interface
     * @param string $configuration The configuration for the dependency 
     *                              instantiation
     * @return Component
     * @throws LogicException
     */
    private function injectDependency($interface, $configuration)
    {   
        if(!isset($this->_dependencies[$interface]))
        {
            return $this->assembleDependency($interface, $configuration);
        }
        else
        {
            throw new LogicException(
                    "Dependency for $interface declared twice?");
        }
    }
    
    /**
     * Assembles (retrieves or generates) a component based on an interface
     * 
     * @param string $interface
     * @param array $configuration
     * @return Component
     */
    private function assembleDependency($interface, $configuration)
    {
        if(!isset($configuration['scope']))
        {
            $configuration['scope'] = ComponentScopes::REQUEST;
        }
        
        $pm = $this->getComponent()->getPathManager();
        $alias = $configuration['class'];
        $class = array_pop(explode('.', $alias));
        $intrfc = array_pop(explode('.', $interface));
        
        $pm->importInterface($interface);
        $pm->importClass($alias);
        
        switch ($configuration['scope'])
        {
            case ComponentScopes::ACCESS:
                $component = new $class($alias);
                break;
            case ComponentScopes::INSTANCE:
                $component = $this->loadInstanceDependency($configuration);
                break;
            case ComponentScopes::REQUEST:
                $component = $this->loadRequestDependency($interface, $configuration);
                break;
            case ComponentScopes::SESSION:
                $component = $this->loadSessionDependency($interface, $configuration);
                break;
        }
        
        if($component instanceof $intrfc)
        {
            if($configuration['scope'] !== ComponentScopes::ACCESS)
            {
                $this->_dependencies[$interface] = $component;
            }
            
            return $component;
        }
        else
        {
            throw new BadMethodCallException("Component of type "
                    . get_class($component). " does not implement the requested"
                    . " interface $intrfc!");
        }
    }
    
    /**
     * 
     * @see loadRequestDependency
     * 
     * @param string $interface_or_id
     * @param string $configuration
     * @param string $scope
     * @return Component
     */
    private function loadComponentDependency($interface_or_id, $configuration, $scope)
    {
        if(!isset(self::$_dependencyPool[$scope][$interface_or_id]))
        {
            $alias = $configuration['class'];
            
            $class = array_pop(explode('.', $alias));
            $instance = new $class($alias);
            
            if(isset($configuration['attributes']) 
                    && is_array($configuration['attributes']))
            {
                $instance->setAttributes($configuration['attributes']);
            }
            
            self::$_dependencyPool[$scope][$interface_or_id] = $instance;
        }
        
        return self::$_dependencyPool[$scope][$interface_or_id];
    }
    
    /**
     * Retrieve or instanciate a Request scoped component
     * 
     * @param string $interface
     * @param array $configuration
     * @return Component
     */
    private function loadRequestDependency($interface, $configuration)
    {
        return $this->loadComponentDependency($interface, $configuration, 'request');
    }
    
    
    /**
     * Retrieve or instanciate an Instance scoped component
     * 
     * @param string $interface
     * @param array $configuration
     * @return Component
     */
    private function loadInstanceDependency($configuration)
    {
        $interface = spl_object_hash($this->getComponent());
        return $this->loadComponentDependency($interface, $configuration, 'instance');
    }
    
    /**
     * Retrieve or instanciate a Session scoped component
     * 
     * @param string $interface
     * @param array $configuration
     * @return Component
     */
    private function loadSessionDependency($interface, $configuration)
    {
        return $this->loadComponentDependency($interface, $configuration, 'session');        
    }
    
    
    /**
     * Instanciates an alias
     * 
     * Does not add it to the dependency pool atm. The scope argument is ignored
     * atm
     * 
     * @param string $component_alias
     * @param string $interface_alias
     * @param integer $scope            Not used atm.
     * @return Component
     */
    public function instanciate(
            $component_alias, $interface_alias = NULL, $scope = NULL)
    {
        if($interface_alias)
        {
            $this->getComponent()->getPathManager()
                    ->importInterface($interface_alias);
        }
        
        $this->getComponent()->getPathManager()->importClass($component_alias);
        
        $class = array_pop(explode('.', $component_alias));
        return new $class($component_alias);
    }
}