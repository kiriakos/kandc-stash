<?php
/**
 * Description of Dispatcher
 *
 * @method type methodName(type $paramName) Description* @author kiriakos
 */
class Dispatcher 
extends Component
implements IDispatcher
{
    
    private $_controller;
    private $_action;
    
    public function dispatch(\IController $controller, \IAction $action) 
    {
        if($this->_action || $this->_controller)
        {
            throw new BadFunctionCallException("This controller (". 
                    $this->getAlias(). ") has already done one dispatch!");
        }
        
        if($controller->filter())
        {
            $action->run();
        }
        $this->_controller = $controller;
        $this->_action = $action;
    }

    /**
     * Gets the injected RenderData Object
     * 
     * @return IRenderData
     */
    public function getRenderData() {
        return parent::getRenderData();
    }

    /**
     * Gets the injected View Object
     * 
     * Dispatcher works with themeable views by default.
     * 
     * @return IThemeableView
     */
    public function getView() {
        return parent::getView();
    }

}