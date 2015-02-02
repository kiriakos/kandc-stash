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
}
