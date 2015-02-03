<?php
return array(
    'di' => array(
        'components.publishing.IImagePublisher' => array(
            'class' => 'components.publishing.ImagePublisher'),
        'components.resources.IUri' => array(
            'class' => 'components.resources.Uri',
            'scope' => ComponentScopes::ACCESS),
    )
);

