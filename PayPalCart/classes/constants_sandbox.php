<?php
// Define Globals
/*defined('DB_SERVER') ? null : define("DB_SERVER", "localhost");
defined('DB_USER') ? null : define("DB_USER", "root");
defined('DB_PASS') ? null : define("DB_PASS", "mysql");
defined('DB_NAME') ? null : define("DB_NAME", "mystore");*/
defined('DB_SERVER') ? null : define("DB_SERVER", "mystore.cooperfam.org");
defined('DB_USER') ? null : define("DB_USER", "ispectr_radmin");
defined('DB_PASS') ? null : define("DB_PASS", "j0sephk#$$");
defined('DB_NAME') ? null : define("DB_NAME", "ispectra_reg");
date_default_timezone_set('America/Los_Angeles');
define('LOG_FILE' , '/home/bayareasummit/cooperfam.org/ispectra');
define('REGULAR_XML_FILE' , '../regular_catalog.xml');
define('EXHIBITORS_XML_FILE' , '../exhibitors_catalog.xml');
define('GROUP_XML_FILE' , '../group_catalog.xml');
define('PAYPAL_BUSINESS_VALUE' , 'engageseller@yahoo.com');
define('PAYPAL_FORM_URL', 'https://www.sandbox.paypal.com/cgi-bin/webscr' );
define('PAYPAL_IPN_RETURN_URL', 'http://cooperfam.org/ispectra/PayPalCart/html/my_ipn.php');
define('PAYPAL_CHECKOUT_COMPLETE_URL', 'http://cooperfam.org/ispectra/registration.php?clear=1');
define('PAYPAL_CANCEL_CHECKOUT_URL', 'http://cooperfam.org/ispectra/PayPalCart/html/clearCart.php?clear=1');



?>