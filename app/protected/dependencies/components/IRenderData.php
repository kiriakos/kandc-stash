<?php
/**
 * Dat to pass to a view
 * 
 * @author kiriakos
 */
interface IRenderData 
{
    
    /**
     * @return array
     */
    public function getData();
    
    
    /**
     * Get data by fragment name
     * 
     * @param mixed $name
     */
    public function getFragment($name);
    
    /**
     * Set data by fragment name
     * 
     * @param string $name
     * @param mixed $value
     */
    public function setData($name, $value = NULL);
}
