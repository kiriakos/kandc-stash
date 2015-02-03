<?php
/**
 * Description of HomeController
 *
 * @author kiriakos
 */
class HomeController 
extends SimpleController
implements IController
{
    public function actionNews()
    {
        return "No News!";
    }
    
    public function actionFakeNews()
    {
        return "These news are fake!";
    }

    protected function getDefaultActionAlias() 
    {
        return 'components.simple.SimpleCallbackAction';
    }

    public function getId() {
        return "Home";
    }

}