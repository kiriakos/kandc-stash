<?php
return array(
    'di' => array(
        'components.publishing.IFilePublisher' => array(
            'class' => 'components.publishing.FilePublisher'
        ),
        "components.util.image.IImageResizer" => array(
            "class" => "components.util.image.ImageResizer",
            "scope" => ComponentScopes::REQUEST
        )
    )
);