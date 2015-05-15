<div id="thumbnail-preview">
<?php

foreach($files as $file)
{
    $id = "Thumbnail_".$file->getIndexInListing();
    $url =  WEB_ROOT. "/". APP_INDEX_FILE. "?path=". rawurlencode($path_current)
            . "&asset=". ($file->getIndexInListing());
    
    echo "<a id=\"$id\" href=\"$url\">";
    if($file->getFileIntrospector()->isImg())
    {
        $path = $file->getFileIntrospector()->assetize()
                ->getThumbnailPath("{WIDTH}","{WIDTH}");
        $url = $file->getFilePublisher()->publishPathString($path)->getUri();

        echo "<img class=\"thumbnail\""
            . " title=\"{$file->getName()}\">";
            
        echo "<script>"
            . "$(function(){ "
            . "     var w = $('#$id').width();"
            . "     var e = $('#$id img');"
            . "     $('#$id').height(w);"
            . "     var uri = '$url'.replace(/{WIDTH}/g, w);"
            . "     nq.image(encodeURI(uri), e);"
            . "})"
            . "</script>";
    }
    //echo "<h6>{$file->getName()}</h6>";
    echo "</a>";
}

?>
</div>