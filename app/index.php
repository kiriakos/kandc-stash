<?php
/**
 * Bootstraps the knc DI Container
 * 
 * system principles:
 * all components reside in class files in /classes
 * all component dependencies are described in class configurations in /configs
 * all component interfaces are described in /interfaces
 * all formal exceptions are in /exceptions
 * all type references happen via aliases
 * 
 * conventions:
 * string identifiers are always lowercase, even request types
 * 
 * system structure:
 * index.php <- this file
 * protected
 *   |- classes
 *   |  |- components
 *   |  |- ....
 *   |- configs
 *   |  |- components
 *   |  |- ....
 *   |- dependencies
 *   |  |- components
 *   |  |- ....
 *   |- exceptions
 *   |- tests <- to be implemented
 * 
 * The Dependencies Folder only Holds Interfaces of official dependencies
 */

include dirname(__FILE__). "/protected/defines.php";
include dirname(__FILE__). "/protected/classes/base/Knc.php";

Knc::get()->run();

exit;
