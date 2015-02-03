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
        $method = 'action'.ucfirst($name);
        $reflector = new ReflectionClass($this);
        
        if($reflector->hasMethod($method))
        {
            $action->setCallback(array($this, $method));
            return $action;
        }
        else
        {
            return NULL;
        }
        
        
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

    /**
     * Redirect to a route
     */
    public function redirect($route, $params = NULL)
    {
        $parameter_string = "";
        
        if(is_array($params) && count($params))
        {
            $parameter_string = "/" . join("/", $params);
        }
        
        header("Location: " . WEB_ROOT. $route. $parameter_string);
    }
}
