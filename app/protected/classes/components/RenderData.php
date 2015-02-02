<?php
/**
 * SimpleRenderData just can hold one string
 *
 * @author kiriakos
 */
class RenderData 
extends Component
implements IRenderData
{
    private $_data = array();
    
    
    /**
     * Get the whole data structure
     * 
     * @return array
     */
    public function getData() 
    {
        return $this->_data;
    }

    /**
     * 
     * @param type $name
     * @param type $value
     */
    public function setData($name, $value = NULL) 
    {
            $this->_data[$name] = $value;
    }

    
    /**
     * This implementation ignores fragments
     * 
     * @param type $name
     * @return type
     */
    public function getFragment($name) 
    {
        return $this->_data[$name];
    }

}
