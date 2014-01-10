<?php
//Define Globals
defined('DB_SERVER') ? null : define("DB_SERVER", "localhost");
defined('DB_USER') ? null : define("DB_USER", "theharv4_builder");
defined('DB_PASS') ? null : define("DB_PASS", "12dml,47Az2");
defined('DB_NAME') ? null : define("DB_NAME", "theharv4_mystore");

define('REGULAR_XML_FILE' , '../regular_catalog.xml');
define('PAYPAL_BUSINESS_VALUE' , 'david@harvestgroupforgod.org');
define('PAYPAL_FORM_URL', 'https://www.paypal.com/cgi-bin/webscr' );
//define('PAYPAL_IPN_RETURN_URL', 'http://www.engageforgod.org/PayPalCart/html/my_ipn.php');
define('PAYPAL_IPN_RETURN_URL', 'http://www.engageforgod.org/PayPalCart/html/complete_listener_IPN.php');
define('PAYPAL_CHECKOUT_COMPLETE_URL', 'http://www.engageforgod.com/thankyou.php?complete=1');
define('PAYPAL_CANCEL_CHECKOUT_URL', 'http://www.engageforgod.org/PayPalCart/html/clearCart.php?clear=1');


?>