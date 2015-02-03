<?php
/**
 * Description of SimpleControllerOrientedAction
 *
 * @author kiriakos
 */
class SimpleCallbackAction
extends Component
implements IAction
{
    private $_callback;
    
    public function setCallback(callable $callback)
    {
        $this->_callback = $callback;
    }

    /**
     * Just executes the callback
     */
    public function run() 
    {
        $this->getRenderData()->setData('run', call_user_func($this->_callback));
    }

    /**
     * Handled by DI
     * 
     * @return IRenderData
     */
    public function getRenderData() 
    {
        return parent::getRenderData();
    }

    /**
     * Handled by DI
     * 
     * @return IView
     */
    public function getView() 
    {
        return parent::getView();
    }

    public function getId() 
    {
        if(is_array($this->_callback))
        {
            return lcfirst(str_replace("action", "", $this->_callback[1]));
        }
        elseif(is_string($this->_callback))
        {
            return lcfirst($this->_callback);
        }
        else
        {
            throw new LogicException("Callback is neither array nor string!"
                    . " What is happening?");
        }
    }

}
