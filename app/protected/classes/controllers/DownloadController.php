<?php
/**
 * Description of DownloadController
 * 
 * @method IRequest getRequest()            Injected dependency
 * @method IFileBrowser getFileBrowser()    Injected dependency
 *
 * @author kiriakos
 */
class DownloadController 
extends SimpleController
implements IController
{
    protected function getDefaultActionAlias() {
        return 'components.simple.SimpleCallbackAction';
    }

    public function getId() {
        return "Download";
    }
    
    public function actionFile()
    {
        $file = $this->getRequest()->getParameter("file");
        $path = $this->getFileBrowser()->getBasePath(). DIRECTORY_SEPARATOR
                . preg_filter("@^".WEB_ROOT."/assets/@","",$file);
        
        if(file_exists($path))
        {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mtype = finfo_file($finfo, $path);
            finfo_close($finfo);
            header("Content-Type: $mtype");
            header("Content-Transfer-Encoding: Binary"); 
            header("Content-Disposition: attachment; filename=\""
                    . basename($path). "\"");
            readfile($path);
        }
        else {
            die("non existing file: $path!");
        }        
            
    }

//put your code here
}
