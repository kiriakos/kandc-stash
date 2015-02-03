<?php

/**
 * Boilerplate functionality of Component class.
 * 
 * factored out to a superclass in order to keep the subclass simpler.
 * 
 * Components do not have a construct phase, they have an init() phase though.
 */
abstract class ComponentBase
{
    private $_dm = NULL;
    private $_inflector = NULL;
    private $_pm = NULL;
    private $_alias = NULL;
    
    /**
     * The component that currently calls this dependency
     * 
     * In the kandc framework dependencies are created and accessed via magic 
     * getters getDependencyName(). The Component Magic call resolution facility
     * automatically sets the current caller that requests a dependency before 
     * returning it. This allows dependencies to access their caller if they 
     * need to.
     *
     * @var Component 
     */
    private $_caller = NULL;
    
    /**
     * The alias of the instance
     * @return type
     */
    public function getAlias() { return $this->_alias; }
    
    /**
     * 
     * @return Inflector
     */
    public function getInflector() { return $this->_inflector; }
    
    /**
     * 
     * @return DependencyManager
     */
    public function getDM() { return $this->_dm; }
    
    /**
     * 
     * @return PathManager
     */
    public function getPathManager() { return $this->_pm; }
    
    /**
     * Load autoconfig
     * 
     */
    public final function __construct($alias)
    {
        $this->_alias = $alias;
        $this->_pm = new PathManager($this);
        $this->_inflector = new Inflector($this);
        $this->_dm = new DependencyManager($this);
        
        $this->getDM()->injectDependencies();
        // Todo: make dependencies lazy loading!
        //$this->getDM()->readDependencyConfiguration();
        
        if(method_exists($this, 'init'))
        {
                $this->init($alias);
        }
    }   
    
    /**
     * Override this function instead of a constructor
     */
    public function init($alias)
    {
        //Does nothing. This is on Purpose!
    }
    
    
    public function setCaller(Component $component)
    {
        $this->_caller = $component;
    }
    
    public function getCaller()
    {
        return $this->_caller;
    }
}
