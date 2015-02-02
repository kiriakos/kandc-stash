<?php
/**
 * Actions related to image browsing
 *
 * @method IRequest getRequest()            Injected dependency
 * @method IFileBrowser getFileBrowser()    Injected dependency
 * @method IRenderData getRenderData()      Injected dependency
 * @method ISanitizer getSanitizer()        Injected dependency. A file path 
 *                                          sanitizer
 
 * @author kiriakos
 */
class ImageBrowserController 
extends SimpleController
implements IController
{
    protected function getDefaultActionAlias() 
    {
        return 'components.simple.SimpleCallbackAction';
    }

    public function actionViewImageInPath()
    {
        $fb = $this->getFileBrowser();
        $asset_number = $this->getRequest()->getParameterOr('asset', 0);
        $path = $this->getRequest()->getParameterOr('path','');
        
        $fb->openDirectory($path);
        $path_current = ($fb->getBasePath() == $fb->getCurrentPath())?
                '':$fb->getRelativeCurrentPath();
        $files = $fb->getFiles();
        $subs = $fb->getSubs();
        
        if($fb->getBasePath() != $fb->getCurrentPath())
        {
            $subs[] = $fb->getBackNode();
        }
        
        if(array_key_exists($asset_number, $files))
        {
            $asset = $files[$asset_number];
        }
        else
        {
            $asset = NULL;
        }
                
        $this->getRenderData()->setData('files',$files);
        $this->getRenderData()->setData('dirs', $subs);
        $this->getRenderData()->setData('path_current', $path_current);
        $this->getRenderData()->setDAta('asset', $asset);
        $this->getRenderData()->setData('controller', $this);
    }
    
    public function getSubdirectoryLink(\IFileSystemAsset $dir)
    {
        $path_dirty = $this->getRequest()->getParameterOr('path','');
        
        $path = $this->getSanitizer()->sanitize($path_dirty);
        
        $dir_name = basename($dir->getPath());
        $dir_link = WEB_ROOT. "/". APP_INDEX_FILE
                        . "?path={$path}/{$dir_name}";
        return $this->getSanitizer()->sanitize($dir_link);
    }

}