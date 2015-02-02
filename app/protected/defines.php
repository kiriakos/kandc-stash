<?php
/**
 * 
 */

// Defines the application file system root.
define('APP_ROOT', realpath(dirname(__FILE__). '/../'));

// Defines the application's web Root. if the application is hosted on a 
// domain's sub directory this will be an absolute path to that sub directory.
// If the application is hosted on a webroot then this will just be `/` also 
// known as "absolute path to root".
define('APP_INDEX_FILE', 'index.php');

// Legacy: $base_url_path
// The path through which the application was called
define('WEB_ROOT', preg_filter('@/'.APP_INDEX_FILE.'$@', '', $_SERVER['SCRIPT_NAME']));
