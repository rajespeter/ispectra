<?php
// Define Globals
defined('DB_SERVER') ? null : define("DB_SERVER", "localhost");
defined('DB_USER') ? null : define("DB_USER", "builder");
defined('DB_PASS') ? null : define("DB_PASS", "12dml,47Az2");
defined('DB_NAME') ? null : define("DB_NAME", "mystore");


define('REGULAR_XML_FILE' , '../regular_catalog.xml');
define('EXHIBITORS_XML_FILE' , '../exhibitors_catalog.xml');
define('GROUP_XML_FILE' , '../group_catalog.xml');
define('PAYPAL_BUSINESS_VALUE' , 'engageseller@yahoo.com');
define('PAYPAL_FORM_URL', 'https://www.sandbox.paypal.com/cgi-bin/webscr' );
define('PAYPAL_IPN_RETURN_URL', 'https://www.mynetglobal.com/PayPalCart/html/my_ipn.php');
define('PAYPAL_CHECKOUT_COMPLETE_URL', 'http://www.mynetglobal.com/engageforgod/registration.php?clear=1');
define('PAYPAL_CANCEL_CHECKOUT_URL', 'http://www.mynetglobal.com/PayPalCart/html/clearCart.php?clear=1');


?>