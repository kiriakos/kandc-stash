<?php

/**
 * Description of ImagesController
 *
 * @method IImageResizer getImageResizer()
 * @method IFileSystemAsset getFileSystemAsset()
 * @method IFilePublisher getFilePublisher() 
 * @author kiriakos
 */
class ImagesController 
extends SimpleController
implements IController
{
    protected function getDefaultActionAlias() 
    {
        return 'components.simple.SimpleCallbackAction';
    }

    public function actionImages()
    {
        $file = preg_replace("/". str_replace("/", "\/", WEB_ROOT)
                    . "\/(images|thumbnails)/", "", $_SERVER["REQUEST_URI"]);
        
        $destination = $_SERVER["REQUEST_URI"];
        $width = preg_filter("/\/(\d+)\/.*/", "\\1", $file);
        $path = APP_ROOT . DIRECTORY_SEPARATOR 
                . rawurldecode(preg_filter("/\/\d+\/(.*)/", "\\1", $file));
        
        $asset = $this->getFileSystemAsset();
        $asset->setPath($path);
        $image = $asset->getFileIntrospector()->assetize();
        $file = $this->getImageResizer()->createImage($image, $width);
        
        header("Location: ". $this->getFilePublisher()
                ->publishPathString($file)->getUri());
    }
    
    public function actionThumbnails()
    {
        $file = preg_replace("/". str_replace("/", "\/", WEB_ROOT)
                    . "\/(images|thumbnails)/", "", $_SERVER["REQUEST_URI"]);
        
        $width = preg_filter("/\/(\d+)_(\d+)\/.*/", "\\1", $file);
        $height = preg_filter("/\/(\d+)_(\d+)\/.*/", "\\2", $file);
        $path = APP_ROOT . DIRECTORY_SEPARATOR 
                . rawurldecode(preg_filter("/\/\d+_\d+\/(.*)/", "\\1", $file));
    }

    public function getId() {
        return "Images";
    }

}
