<?php
return array(
  'di' => array(
      'components.IRenderData' => array(
          'class' => 'components.RenderData',
          'scope' => ComponentScopes::REQUEST),
      'components.IView' => array(
          'class' => 'components.themeable.ThemeableView',
          'scope' => ComponentScopes::INSTANCE)
  )
);