<?php
/**
 * Application flow Controller
 *
 * determines on which models an action will be performed. Controllers also 
 * have Action Resolution functions like findActionByName
 * 
 * @author kiriakos
 */
interface IController 
{
    /**
     * Rertrieve a model
     * 
     * @param mixed $id
     */
    public function loadModel($id);
    
    
    /**
     * Creates a new instance of a persistable model
     */
    public function createModel();
    
    
    public function findActionByName($name);
    
    /**
     * Filter the request based on Controller Logic
     * 
     * @return boolean
     */
    public function filter();
    
    
    /**
     * Get the id of the controller.
     * 
     * The ID has to be unique, system wide.
     */
    public function getId();
    
    /**
     * Redirect to a route
     */
    public function redirect($route, $params = NULL);
}
