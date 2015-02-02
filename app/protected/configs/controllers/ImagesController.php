<?php
return array(
    'di' => array(
        'components.util.IFileSystemAsset' => array(
            'class' => 'components.util.FileSystemAsset',
            'scope' => ComponentScopes::ACCESS
        ),
        "components.util.image.IImageResizer" => array(
            "class" => "components.util.image.ImageResizer",
            "scope" => ComponentScopes::REQUEST
        ),
        'components.publishing.IFilePublisher' => array(
            'class' => 'components.publishing.FilePublisher'
        ),
    )
);