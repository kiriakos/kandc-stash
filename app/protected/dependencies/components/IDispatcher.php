<?php
/**
 *
 * @author kiriakos
 */
interface IDispatcher 
{
    /**
     * 
     * @param IController $controller
     * @param IAction $action
     */
    public function dispatch(IController $controller, IAction $action);
    
    
    /**
     * Retrieve the View Model to use
     * 
     * @return iView
     */
    public function getView();
    
    
    /**
     * Retrieve the data to apply on the view
     * 
     * @return IRenderData
     */
    public function getRenderData();
}
