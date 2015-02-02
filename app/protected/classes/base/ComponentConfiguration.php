<?php
/**
 * Description of ComponentConfiguration
 *
 * @author kiriakos
 */
class ComponentConfiguration 
{
    private $_dependencies = array();
    
    public function __construct($config_path)
    {
        if(file_exists($config_path))
        {
            $config = include $config_path;
            
            if(is_array($config))
            {
                $this->setUpProperties($config);
            }
        }
    }
    
    /**
     * 
     * @param array $config
     */
    private function setUpProperties($config)
    {
        if(isset($config['di']) && is_array($config['di']))
        {
            $this->_dependencies = $config['di'];
        }
    }
    
    /**
     * Get the dependencies descibed in the configuration
     * 
     * @return array
     */
    public function getDependencies()
    {
        return $this->_dependencies;
    }
}
