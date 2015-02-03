<?php

include_once dirname(__FILE__). "/Component.php";

/**
 * Holds all components
 *
 * DO NOT INSTANCIATE THIS CLASS ON YOUR OWN!!!
 *  
 * Handles the general program flow 
 *  - route
 *  - dispatch
 *  - render
 *  - end
 *
 * @author kiriakos
 * 
 * @method IRouter getRouter()
 * @method IDispatcher getDispatcher()
 * @method IRenderer getRenderer()
 */
class Knc
extends Component
{
    private static $_instance;
    private static $_has_run = FALSE;
    
    /**
     * Executes the application
     * 
     * also makes sure the application only runs once
     * 
     * @throws Exception
     */
    public function run()
    {
        if(self::$_has_run)
        {
            throw new Exception("You can't Run KnC more than once!");        
        }
        
        $this->route();
        $this->dispatch();
        $this->render();
        $this->end();
    }
    
    public function route()
    {
        $this->getRouter()->route($this->getRequest());
    }
    
    public function dispatch()
    {
        $this->getDispatcher()->dispatch(
                $this->getRouter()->getController(),
                $this->getRouter()->getAction()
        );
    }
    
    public function render()
    {
        $this->getRenderer()->render(
                $this->getDispatcher()->getView(),
                $this->getDispatcher()->getRenderData()
        );
    }
    
    public function end()
    {
        exit(0);
    }
        
    public static function get()
    {
        if(self::$_instance === NULL)
        {
            self::$_instance = new Knc('base.Knc');
        }
        
        return self::$_instance;
    }
}