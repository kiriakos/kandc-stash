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
    
    /**
     * Checks if the passed request is automaticaly routable.
     * 
     * Routable in this context is a request that can map to a controller/action
     * combo based on the Request URI.
     *  
     * @param \IRequest $request
     * @return mixed
     */
    public function parseAutoRoutable(\IRequest $request)
    {
        $route = preg_replace("@^/@", "", str_replace(WEB_ROOT, "", 
                $request->getRequestPath()));
        
        if(!is_string($route))
        {
            return FALSE;
        }
        
        $parts = $this->parseRoute($route);
        
        if(!$parts[0] || !$parts[1])
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
        }
        
        return FALSE;
    }
    
    /**
     * Custom routes
     * 
     * Map a route to the regex the should match it. The path to be matched 
     * against is the request URIs path component minut the value of WEB_ROOT.
     * 
     * @var array
     */
    private $_custom_routes = array(
        'images/images' => "images/\d+/.+",
        'images/thumbnails' => "thumbnails/\d+_\d+/.+",
    );
    
    /**
     * Whether the route can be routed based on the request URI and $_custom_routes
     * 
     * @param \IRequest $request
     * @return mixed
     */
    public function parseCustomRoutable(\IRequest $request)
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
     * Processes a request into a controller/action route
     * 
     * @param \IRequest $request
     * @return string
     */
    private function processRequestToRoute(\IRequest $request)
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
        
        return $this->parseRoute($route);
    }
    
    /**
     * Populates the Controller and Action properties if the Router
     * 
     * @param \IRequest $request
     */
    public function route(\IRequest $request)
    {
        list($controller, $action, $params) = $this
                ->processRequestToRoute($request);
        
        $this->_controller = $this->findControllerByName($controller);
        $this->_action = $this->_controller->findActionByName($action);
        $this->_action->setParameters($params);
    }
    
    /**
     * Returns an array of Controller Name and Action Name and parameters
     * 
     * In case of failure an array of type:
     *      array("","", array())
     * 
     * is returned.
     * 
     * @return array
     */
    private function parseRoute($route)
    {
        $components = explode('/', $route);
        
        if(!is_array($components) || count($components) < 2)
        {
            return array("","", array());
        }
        else
        {
            return array(ucfirst($components[0]), ucfirst($components[1]), 
                array_slice($components, 2));
        }
    }
    
    /**
     * Get a IControler instance given it's call name
     * 
     * @param string
     * @return IController
     */
    public function findControllerByName($controller)
    {
        if(!$controller)
        {
            throw new LogicException("Controller attributte canont be empty!");
        }
        
        $classname = $controller. "Controller";
        $alias = 'controllers.'. $classname;
        $this->getPathManager()->importClass($alias);
        
        $ctrlr = new $classname($alias);
        
        return $ctrlr; 
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
