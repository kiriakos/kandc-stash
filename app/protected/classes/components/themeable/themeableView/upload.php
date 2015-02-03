<form
    action="<?php echo $this->getRouter()->generateRelativeUrl('uploads/file'); ?>"
    enctype="multipart/form-data"
    method="post">
    <input type="file" name="submit-file" />
    <input type="text" name="submit-to-path" 
           value="<?php echo $path_current; ?>"/>
    <input type="hidden" name="fallback-path" 
           value="<?php echo $path_current; ?>"/>
    <input type="submit" name="Upload" />
</form>
