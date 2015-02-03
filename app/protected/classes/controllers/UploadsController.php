<?php
/**
 * Description of UploadController
 *
 * @author kiriakos
 */
class UploadsController 
extends SimpleController
implements IController
{
    protected function getDefaultActionAlias() 
    {
        return 'components.simple.SimpleCallbackAction';
    }
    
    public function actionFile()
    {
        $request = $this->getRequest();
        $file = $request->getFile("submit-file");
        $submit_path = $request->getParameter("submit-to-path");
        $fallback_path = $request->getParameter("fallback-path");
        $target_path = $submit_path . DIRECTORY_SEPARATOR . $file["name"];
        
        $asset = $this->getFileBrowser()
                ->publishForeignFile($file["tmp_name"], $target_path);
        
        if($asset instanceof IFileSystemAsset)
        {die("Succ");
            header("Location: ". WEB_ROOT . "/?path="
                    . rawurlencode($submit_path) . "&asset="
                    . $asset->getIndexInListing());
        }
        else
        {
            header("Location: ". WEB_ROOT. "/?path="
                    . rawurlencode($fallback_path));
            
        }
        Knc::get()->end();
    }

    public function getId() {
        return "uploads";
    }

}