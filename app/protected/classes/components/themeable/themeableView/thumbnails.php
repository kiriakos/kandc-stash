<div id="thumbnail-preview">
<?php

foreach($files as $file)
{
    $id = "Thumbnail_".$file->getIndexInListing();
    $url =  WEB_ROOT. "/". APP_INDEX_FILE. "?path=". $path_current. "&asset="
            . ($file->getIndexInListing());
    
    echo "<a id=\"$id\" href=\"$url\">";
    if($file->getFileIntrospector()->isImg())
    {
        $path = $file->getFileIntrospector()->assetize()
                ->getThumbnailPath("{WIDTH}","{WIDTH}");
        $url = $file->getFilePublisher()->publishPathString($path)->getUri();

        echo "<img class=\"thumbnail\" width=\"20%\""
            . " title=\"{$file->getName()}\">";
            
        echo "<script>"
            . "$(function(){ "
            . "     $('#$id img').attr('src', encodeURI('$url'.replace("
            . "         /{WIDTH}/g, $('#$id img').width())))"
            . "})"
            . "</script>";
    }
    echo "<h6>{$file->getName()}</h6>";
    echo "</a>";
}

?>
</div>