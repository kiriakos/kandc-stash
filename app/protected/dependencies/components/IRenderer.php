<?php
/**
 *
 * @author kiriakos
 */
interface IRenderer 
{
    public function render(IView $view, IRenderData $data);
}
