<?php
/**
 * Inspects the request and determines which controller action Combo to use
 * 
 * May also just issue a redirect or stop the application
 *
 * @author kiriakos
 */
interface IRouter 
{
    function route(\IRequest $request);
    function generateRoute(\IController $controller, \IAction $action);
    
    /**
     * Generate a Url from a controller-action combination
     * 
     * @param string $route     Slash separated route
     * @param array $params     Array of action parameters
     */
    function generateRelativeUrl($route, $params = NULL);
    
    function getController();
    function getAction();
}
