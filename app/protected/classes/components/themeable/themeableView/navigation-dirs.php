<div>
    <div id="navigation_dirs">
        <ul>
        <?php
            /* @var $subdirectory IFileSystemAsset */

            foreach($dirs as $subdirectory)
            {   ?>
                <li>
                <div>
                <a class="button" 
                   title="<?php echo $subdirectory->getName(); ?>"
                   href="<?php echo $controller->getSubdirectoryLink($subdirectory);?>">
                       <?php echo $subdirectory->getName(); ?>
                </a>
                </div>
                <li>
                <?php
            }
            unset($subdirectory);
        ?>
        </ul>
    </div>
</div>