<?php
return array(
    'di' => array(
        'components.IRequest' => array(
            'class' => 'components.Request',
            'scope' => ComponentScopes::REQUEST),
        'components.util.IFileBrowser' => array(
            'class' => 'components.util.FileBrowser',
            'scope' => ComponentScopes::INSTANCE,
            'attributes' => array('InitPath' => 'assets')),
        'components.IRenderData' => array(
            'class' => 'components.RenderData',
            'scope' => ComponentScopes::REQUEST),
        'components.util.ISanitizer' => array(
            'class' => 'components.util.FileSystemPathSanitizer',
            'scope' => ComponentScopes::REQUEST),
  )  
);