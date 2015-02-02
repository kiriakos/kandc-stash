<div id="asset">
<?php
    //Image
    if($asset && $asset_name)
    {
        if(is_img($asset_name))
            echo "<img width=\"100%\" title=\"$asset_name\"".
                " src=\"$asset\" />";
        echo "<h4>$asset_name</h4>";
    }
?>
</div>
