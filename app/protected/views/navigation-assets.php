
<div id="navigation_assets">
<?php
    //Navigation assets
    if($asset && $asset_name)
    {
        if($asset_index > 0)
        echo "<a class=\"asset_prev button\""
            ."href=\"$base_url_path/?path=$path_current&asset="
            . ($asset_index -1) . "\">Prev ("
            . $asset_index. ")</a>";
        if($asset_index < count($files) - 1)
        echo "<a class=\"asset_next button\""
            . "href=\"$base_url_path/?path=$path_current&asset="
            . ($asset_index +1). "\">Next ("
            . (count($files) - $asset_index - 1). ")</a>";
    }
?>
</div>
