<?php

class PathManager
extends ComponentHelper
{        
    /**
     * Returns the path of the application root
     * 
     * @param string $alias
     * @param integer $type
     * @return string
     */
    public static function getPathOfAlias(
            $alias, 
            $type = PathTypes::CLASS_FILE)
    {
        switch($type){
            case PathTypes::CLASS_FILE:
                return APP_ROOT. "/protected/classes/"
                        .str_replace('.', '/', $alias). '.php';
                
            case PathTypes::INTERFACE_FILE:
                return APP_ROOT. "/protected/dependencies/"
                        . str_replace('.', '/', $alias). '.php';
                
            case PathTypes::CONFIG_FILE:
                return APP_ROOT. '/protected/configs/'
                        . str_replace('.', '/', $alias). '.php';
                
            default :
                throw new Exception("$type must de defined in PathTypes!");
        }
    }
    
    /**
     * Get the absolute path to the component's config file
     * 
     * @return string
     */
    public function getConfigFilePath()
    {
        return $this->getPathOfAlias($this->getComponent()->getAlias(), 
                PathTypes::CONFIG_FILE);
    }
    
    public function importClass($alias)
    {
        $file = $this->getPathOfAlias($alias, PathTypes::CLASS_FILE);
        if(is_file($file))
        {
            include_once $file;
        }
        else
        {
            throw new BadMethodCallException("$alias doesn't map to a File!");
        }
    }
    
    public function importInterface($alias)
    {
        include_once $this->getPathOfAlias($alias, PathTypes::INTERFACE_FILE);
    }
    
}
