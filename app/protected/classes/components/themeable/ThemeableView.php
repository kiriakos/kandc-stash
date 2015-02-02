<?php
/**
 * Description of ThemeableView
 *
 * @author kiriakos
 */
class ThemeableView 
extends Component
implements IView
{
    public function compute(\IRenderData $render_data) 
    {
        $file_path = $this->getPathManager()->getPathOfAlias($this->getAlias());
        $view_path = dirname($file_path);
        $templates_path = $view_path. DIRECTORY_SEPARATOR. 'themeableView';
        
        extract($render_data->getData());
        
        ob_start();
        include $templates_path. DIRECTORY_SEPARATOR. 'view.php';
        
        return ob_get_clean();
    }
    
    public function render($file)
    {
        throw new Exception('ThemeableView::render($file) has not been'
                . ' implemented jet!');
    }
}
