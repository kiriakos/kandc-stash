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
    function getController();
    function getAction();
}
