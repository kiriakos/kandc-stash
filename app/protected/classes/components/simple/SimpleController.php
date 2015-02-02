<?php

/**
 * Description of HomeController
 *
 * @author kiriakos
 */
abstract class SimpleController 
extends Component
implements IController
{
    abstract protected function getDefaultActionAlias();
    
    public final function init($alias)
    {
        $this->getPathManager()->importClass($this->getDefaultActionAlias());
    }
    
    public function createModel() 
    {
        throw new Exception('Not implemented: createModel().', '000', '000');
    }

    /**
     * 
     * @param string $name
     * @return \SimpleCallbackAction
     */
    public function findActionByName($name) 
    {
        $action = $this->getDM()->instanciate($this->getDefaultActionAlias());
        $action->setCallback(array($this, 'action'.$name));
        
        return $action;
    }

    /**
     * This type of controller does not load models by default
     * 
     * @param type $id
     */
    public function loadModel($id) 
    {
        throw new Exception('Not implemented: loadModel().', '000', '000');
    }
    
    /**
     * This controller does not have validation
     * 
     * @return boolean
     */
    public function filter() 
    {
        return TRUE;
    }

}
