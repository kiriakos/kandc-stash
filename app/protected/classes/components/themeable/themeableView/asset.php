<a href="#asset">

</a>
<div id="asset">
<?php
    //Image
    // This way also naturally filters NULL pointers.
    if($asset instanceof IFileSystemAsset)
    {
        if($asset->getFileIntrospector()->isImg())
        {
            $path = $asset->getFileIntrospector()->assetize()
                    ->getImagePath("{WIDTH}");
            $url = $asset->getFilePublisher()->publishPathString($path)
                    ->getUri();
            $download_path = WEB_ROOT . "/download/file?file=" 
                    . $asset->getFilePublisher()
                            ->publishCaller()
                            ->getUri();
            
            echo "<img class=\"image\" width=\"100%\""
                . " title=\"{$asset->getName()}\">";
                
            echo "<script>"
                . "$(function(){ $('#asset img').attr('src', encodeURI('$url'.replace('{WIDTH}', "
                    . "$('#asset img').width()))) })"
                    . "</script>";
            echo "<h4><a href=\"mailto:webapps@apple.com?subject=Copy%20Link&body=https://kindstudios.gr$download_path\">";
            echo "{$asset->getName()}";
            echo "</a></h4>";
        }
        else
        {
            echo "<h4>{$asset->getName()}</h4>";
        }
    }
    elseif(is_null($asset))
    {
        echo "No Asset given!";
    }
?>
</div>
