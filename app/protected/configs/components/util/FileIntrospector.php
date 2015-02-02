<?php
return array(
    'di' => array(
        'components.util.image.IImage' => array(
            'class' => 'components.util.image.Image',
            'scope' => ComponentScopes::ACCESS,
        ),
    )
);