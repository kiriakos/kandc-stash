<?php
return array(
    'di' => array(
        'components.util.IFileSystemAsset' => array(
            'class' => 'components.util.FileSystemAsset',
            'scope' => ComponentScopes::ACCESS
        ),
        'components.util.ISanitizer' => array(
            'class' => 'components.util.FileSystemPathSanitizer',
            'scope' => ComponentScopes::REQUEST,)
    )
);

