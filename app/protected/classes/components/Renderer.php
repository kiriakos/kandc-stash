<?php
/**
 * Description of Renderer
 *
 * @author kiriakos
 */
class Renderer 
extends Component
implements IRenderer
{
    public function render(IView $view, IRenderData $data) 
    {
        echo $view->compute($data);
    }

}
