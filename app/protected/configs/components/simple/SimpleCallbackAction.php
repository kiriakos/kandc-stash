<?php
return array(
  'di' => array(
      'components.IRenderData' => array(
          'class' => 'components.simple.SimpleRenderData',
          'scope' => ComponentScopes::REQUEST),
      'components.IView' => array(
          'class' => 'components.simple.SimpleView',
          'scope' => ComponentScopes::INSTANCE)
  )
);