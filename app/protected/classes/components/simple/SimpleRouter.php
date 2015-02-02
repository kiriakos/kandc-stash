<?php
/**
 * Consumes the request and routes it to a controller
 * 
 * Dispatching is done here as well
 *
 * @author kiriakos
 */
class SimpleRouter 
extends Component
implements IRouter
{
    const DEFAULT_ROUTE = 'ImageBrowser/ViewImageInPath';
    
    private $_controller;
    private $_action;
    
    public function init($alias)
    {
        $this->getPathManager()->importInterface('components.IController');
        $this->getPathManager()->importInterface('components.IAction');
        $this->getPathManager()->importClass('components.simple.SimpleController');
    }
    
    
    public function route(\IRequest $request)
    {
        $route = $request->getParameter('route');
        
        if(!$route)
        {
            if(preg_match("/". str_replace("/", "\/", WEB_ROOT)
                    . "\/(images|thumbnails)/", $_SERVER["REQUEST_URI"]))
            {
                $route = "images/". preg_replace("/". str_replace("/", "\/", WEB_ROOT)
                    . "\/(images|thumbnails).*/", "\\1", $_SERVER["REQUEST_URI"]);
            }
            else 
            {
                $route = self::DEFAULT_ROUTE;
            }
        }
        
        list($controller, $action) = $this->parseRoute($route);
        
        $this->_controller = $this->findControllerByName($controller);
        $this->_action = $this->_controller->findActionByName($action);
    }
    
    /**
     * Returns an array of Controller Name and Action Name
     * @return array
     */
    private function parseRoute($route)
    {
        list($controller, $action) = explode('/', $route);
        
        return array(ucfirst($controller), ucfirst($action));
    }
    
    
    /**
     * Get a IControler instance given it's call name
     * 
     * @param string
     * @return IController
     */
    private function findControllerByName($controller)
    {
        $classname = $controller. "Controller";
        $alias = 'controllers.'. $classname;
        $this->getPathManager()->importClass($alias);
        
        return new $classname($alias);
    }

    public function getController() {
        return $this->_controller;
    }

    public function getAction() {
        return $this->_action;
    }

    public function generateRoute(\IController $controller, \IAction $action)
    {
        return get_class($controller). '/'. get_class($action);
    }

}
