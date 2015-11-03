<?php
/**
 * Description of UploadController
 *
 * @author kiriakos
 * @method IFileBrowser getFileBrowser()    File Browser dependency
 * @method IRequest     getRequest()        HTTP Request
 */
class UploadsController 
extends SimpleController
implements IController
{
    protected function getDefaultActionAlias() 
    {
        return 'components.simple.SimpleCallbackAction';
    }
    
    private function findName($file, $submit_path, $override){
        
        $repl_count = 0;
        $target_path = $submit_path . DIRECTORY_SEPARATOR . $file["name"];
        $final_path = $target_path;
        
        while($this->getFileBrowser()->fileInPathExists($final_path)
                && $override == FALSE){
            $repl_count += 1;
            $parts = explode(".", $target_path);
            $ext = array_pop($parts);
            $name = join(".", $parts);
            $final_path = $name . "_" . $repl_count . "." . $ext;
        }
        
        return $final_path;
    }
    
    
    /**
     * Creates a file.
     * 
     * 
     */
    public function actionFile()
    {
        $request = $this->getRequest();
        $browser = $this->getFileBrowser();
        $file = $request->getFile("submit-file");
        $submit_path = $request->getParameter("submit-to-path");
        $fallback_path = $request->getParameter("fallback-path");
        $override = $request->getParameterOr("override-existing", FALSE);
        //die(var_dump($override));
        
        try
        {
            $final_path = $this->findName($file, $submit_path, $override);
            $asset = $browser->publishForeignFile($file["tmp_name"], 
                    $final_path);
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
