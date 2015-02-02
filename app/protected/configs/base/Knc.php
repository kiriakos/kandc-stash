<?php
/**
 * Array struct:
 * 
 * Dependencies:
 *  - are identified by the interfaces they provide
 * 
 * di:
 *  array keys are Interface aliases array values are instantiation recipes in
 *  associative array format. The dependency will be injected into the property
 *  named after the interface class. The theory here is that having two 
 *  similarily named Interfaces in the same class is usually a notion of bad 
 *  separation of concerns
 */
return array(
  'di' => array(
      'components.IRouter' => array(
          'class' => 'components.simple.SimpleRouter',
          'scope' => ComponentScopes::REQUEST),
      'components.IDispatcher' => array(
          'class' => 'components.Dispatcher',
          'scope' => ComponentScopes::REQUEST),
      'components.IRenderer' => array(
          'class' => 'components.Renderer',
          'scope' => ComponentScopes::REQUEST),
      'components.IRequest' => array(
          'class' => 'components.Request',
          'scope' => ComponentScopes::REQUEST)
  )  
);