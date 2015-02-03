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
    
    private function parseAutoRoutable(\IRequest $request)
    {
        $route = preg_replace("@^/@", "", str_replace(WEB_ROOT, "", 
                $request->getRequestPath()));
        
        if(!is_string($route))
        {
            return FALSE;
        }
        
        $parts = $this->parseRoute($route);

        if($parts[0] == "" || $parts[1] == "")
        {
            return FALSE;
        }

        try
        { 
            $controller = $this->findControllerByName($parts[0]);
            $action = $controller->findActionByName($parts[1]);

            if($action instanceof IAction 
                    && $controller instanceof IController)
            {
                return $controller->getId() . "/" . $action->getId();
            }        
        }
        catch(Exception $e)
        {
            return FALSE;
        }
    }
    
    private $_custom_routes = array(
        'images/images' => "images/\d+/.+",
        'images/thumbnails' => "thumbnails/\d+/.+",
    );
    
    /**
     * Whether the route can be routed based on the request URI and $_custom_routes
     * 
     * @param \IRequest $request
     * @return mixed
     */
    private function parseCustomRoutable(\IRequest $request)
    {
        foreach($this->_custom_routes as $route => $verify)
        {
            $matcher = str_replace('/', '\/', WEB_ROOT . '/' . $verify);
            
            if(preg_match("/$matcher/", $request->getRequestPath()) === 1)
            {
                return $route;
            }
        }
        return FALSE;
    }
    
    /**
     * Populates the Controller and Action properties if the Router
     * 
     * @param \IRequest $request
     */
    public function route(\IRequest $request)
    {
        $route = $request->getParameter('route');
        
        if(!$route)
        {
            $route = $this->parseAutoRoutable($request);
        }
        if(!$route)
        {
            $route = $this->parseCustomRoutable($request);
        }
        if(!$route)
        {
            $route = self::DEFAULT_ROUTE;
        }
    
        list($controller, $action, $params) = $this->parseRoute($route);
        
        $this->_controller = $this->findControllerByName($controller);
        $this->_action = $this->_controller->findActionByName($action);
    }
    
    /**
     * Returns an array of Controller Name and Action Name
     * @return array
     */
    private function parseRoute($route)
    {
        $components = explode('/', $route);
        
        return array(ucfirst($components[0]), ucfirst($components[1]), 
            array_slice($components, 2));
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
        return $controller->getId(). '/'. $action->getId();
    }

    
    public function generateRelativeUrl($route, $params = NULL) 
    {
        $relative = WEB_ROOT . "/" . $route;
        
        if(is_array($params) && count($params) > 0)
        {
            $relative .= "/" . join("/", array_values($params));
        }
        
        return $relative;
    }

}
