<div>
    <div id="navigation_dirs">
    <?php
        //Navigation Dirs
        foreach($dirs as $file => $path)
        {
            echo "<a class=\"button\" title=\"$file\" "
                    . " href=\"$base_url_path/?path=$path_current/$file\">$file</a> ";
        }
    ?>
    </div>
</div>
