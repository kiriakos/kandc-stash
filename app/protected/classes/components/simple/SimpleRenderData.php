<?php
/**
 * SimpleRenderData just can hold one string
 *
 * @author kiriakos
 */
class SimpleRenderData 
extends Component
implements IRenderData
{
    private $_data;
    
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
        if($value)
        {
            $this->_data = $value;
        }
        else
        {
            $this->_data = $name;
        }
    }

    
    /**
     * This implementation ignores fragments
     * 
     * @param type $name
     * @return type
     */
    public function getFragment($name) 
    {
        return $this->getData();
    }

}
