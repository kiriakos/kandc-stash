
<form
    action="<?php echo $this->getRouter()->generateRelativeUrl('uploads/file'); ?>"
    enctype="multipart/form-data"
    method="post"
    class="upload">
    
    <div>
        <input type="text" name="submit-to-path" 
               value="<?php echo $path_current; ?>"/>
        <input type="file" name="submit-file" />
        <input type="hidden" name="fallback-path" 
               value="<?php echo $path_current; ?>"/>
    </div>
    
    <input type="submit" name="Upload" />
    
</form>
