<?php
return array(
    "di" => array(
        'components.IRouter' => array(
          'class' => 'components.simple.SimpleRouter',
          'scope' => ComponentScopes::REQUEST),
        'components.IRequest' => array(
          'class' => 'components.Request',
          'scope' => ComponentScopes::REQUEST)
    ),
);