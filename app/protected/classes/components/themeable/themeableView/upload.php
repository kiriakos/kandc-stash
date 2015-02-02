<form
    action="<?php echo WEB_ROOT; ?>"
    enctype="multipart/form-data">
    <input type="file" name="submit-file" />
    <input type="text" name="submit-to-path" 
           value="<?php echo $path_current; ?>"/>
    <input type="submit" name="Upload" />
</form>
