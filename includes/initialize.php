<?php


ob_start(); 
// Define the core paths
// Define them as absolute paths to make sure that require_once works as expected

// DIRECTORY_SEPARATOR is a PHP pre-defined constant
// (\ for Windows, / for Unix)
define('DS','/');
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

//define('SITE_ROOT','/Users/Guest/Sites/ispectra');
//define('SITE_ROOT','/home/bayareasummit/cooperfam.org/ispectra');
//live site:
// define('SITE_ROOT','/home/bayareasummit/ispectraignite.org/ispectra');
//gc stage dev:
// define('SITE_ROOT','/home/35366/domains/gcgrafix.com/html/stage/ispectra/ispectra');
//gc local dev:
define('SITE_ROOT','/Applications/MAMP/htdocs/ispectraignite.dev/ispectra');

//for header.php and footer.php
if (strpos(SITE_ROOT,'ispectraignite.dev') !== false) {
    define('BASE_URL','ispectraignite.dev');
} elseif (strpos(SITE_ROOT,'gcgrafix.com') !== false) {
    define('BASE_URL','gcgrafix.com/stage/ispectra');
} elseif (strpos(SITE_ROOT,'ispectraignite.org') !== false) {
      define('BASE_URL','www.ispectraignite.org');
    }

defined('SITE_ROOT') ? null : 
	define('SITE_ROOT', DS.'Applications'.DS.'XAMPP'.DS.'xamppfiles'.DS.'htdocs'.DS.'harvestgroup'.DS.'engageforgod'); //change these to match your site

defined('LIB_PATH') ? null : define('LIB_PATH', SITE_ROOT.DS.'includes');

// load basic functions next so that everything after can use them

require_once(LIB_PATH.DS.'functions.php');

?>