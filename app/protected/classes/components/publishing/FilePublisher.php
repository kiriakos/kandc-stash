<?php
/**
 * Publishes files to web accessible directories, provides links.
 * 
 * NOTE:    This implementation is Lazy! It assumes the actual position is 
 *          already web accessible and just cuts out the part from the FS root.
 *
 * @method IImagePublisher getImagePublisher()  Dependency
 * @method IUri            getUri()             Dependency
 * @author kiriakos
 */
class FilePublisher 
extends Component
implements IFilePublisher
{
    public function publishAsset(\IFileSystemAsset $asset) 
    {
        $url = WEB_ROOT. preg_filter("#".APP_ROOT."#", '', $asset->getPath());
        $uri = $this->getUri();
        $uri->setUri($url);
        return $uri;
    }

    public function publishCaller() 
    {
        return $this->publishAsset($this->getCaller());
    }

    /**
     * 
     * @param string $string
     */
    public function publishPathString($string) 
    {
        $url = WEB_ROOT. preg_filter("#".APP_ROOT."#", '', $string);
        $uri = $this->getUri();
        $uri->setUri($url);
        
        return $uri;
    }

    public function publishForeignFile(\IFileSystemAsset $file, $path) 
    {
        
        $destination
    }

}