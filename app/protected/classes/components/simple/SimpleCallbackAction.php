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

}
