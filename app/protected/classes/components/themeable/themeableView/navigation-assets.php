
<div id="navigation_assets">
<?php
    /**
     * @var $asset IFileSystemAsset
     */
    if($asset instanceof IFileSystemAsset)
    {
        $asset_index = $asset->getIndexInListing();
        
        //TODO: These could easily be small widget invocations
        if($asset_index > 0)
        {
            $asset_url = WEB_ROOT. "/". APP_INDEX_FILE. "?path=". $path_current
                    . "&asset=". ($asset_index -1);
            ?>
                <a class="asset_prev button"
                   href="<?php echo $asset_url;?>"
                   >
                        Prev (<?php echo $asset_index; ?>)
                </a>
            <?php
            unset($asset_url);
        }
        
        if($asset_index < count($files) - 1)
        {
            $asset_url = WEB_ROOT. "/". APP_INDEX_FILE. "?path=". $path_current
                    . "&asset=". ($asset_index +1);
            ?>
                <a class="asset_next button"
                   href="<?php echo $asset_url;?>"
                   >
                        Next (<?php echo count($files) - $asset_index - 1; ?>)
                </a>
            <?php
            unset($asset_url);
        }
        
        unset($asset_index);
    }
?>
</div>
