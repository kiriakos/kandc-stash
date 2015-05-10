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
    
    
    /**
     * Creates a file.
     * 
     * 
     */
    public function actionFile()
    {
        $request = $this->getRequest();
        $file = $request->getFile("submit-file");
        $submit_path = $request->getParameter("submit-to-path");
        $fallback_path = $request->getParameter("fallback-path");
        $target_path = $submit_path . DIRECTORY_SEPARATOR . $file["name"];
        
        try
        {
            $asset = $this->getFileBrowser()
                    ->publishForeignFile($file["tmp_name"], $target_path);
        }
        catch (BadMethodCallException $ex)
        {
            die($ex->getMessage());
        }
        
        if($asset instanceof IFileSystemAsset)
        {
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
