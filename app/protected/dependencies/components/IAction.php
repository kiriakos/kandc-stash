<?php
/**
 * Action public interfaces
 * 
 * In the KnC framework actions are single items of execution logic.
 * the provide getters for teh view they would like to render and for getting 
 * the IRenderData instance they are working on.
 *
 * @author kiriakos
 */
interface IAction 
{
    
    /**
     * The view the Action would prefer to be rendered.
     * 
     * The final View to be rendered is still controlled by the Dispatcher
     * 
     * @return IView
     */
    public function getView();
            
    /**
     * @return IRenderData
     */
    public function getRenderData();
    
    /**
     * Execute the logic
     * 
     * @return boolean
     */
    public function run();
    
    /**
     * Get the id of the controller.
     * 
     * The ID has to be unique, system wide.
     */
    public function getId();
    
    /**
     * Set the parameters pased with the request
     * 
     * This is used by the Router @ route(\IRequest).
     * End users should be more interested in the getter of this.
     * 
     * @param array $array
     */
    public function setParameters($array);
    
    /**
     * Get the request parameters set by the Router
     * 
     * @see setParameters
     * @return $array
     */
    public function getParameters();
}
