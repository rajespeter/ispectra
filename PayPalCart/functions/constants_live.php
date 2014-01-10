<?php
// Define Globals
defined('DB_SERVER') ? null : define("DB_SERVER", "localhost");
defined('DB_USER') ? null : define("DB_USER", "root");
defined('DB_PASS') ? null : define("DB_PASS", "mysql");
defined('DB_NAME') ? null : define("DB_NAME", "mystore");

define('REGULAR_XML_FILE' , '../regular_catalog.xml');
define('PAYPAL_BUSINESS_VALUE' , 'your_paypal_login_email_address');
define('PAYPAL_FORM_URL', 'https://www.paypal.com/cgi-bin/webscr' );
define('PAYPAL_IPN_RETURN_URL', 'https://www.yourdomainname.com/PayPalCart/html/my_ipn.php');
define('PAYPAL_CHECKOUT_COMPLETE_URL', 'http://www.yourdomainname.com/registration.php?clear=1');
define('PAYPAL_CANCEL_CHECKOUT_URL', 'http://www.yourdomainname.com/PayPalCart/html/clearCart.php?clear=1');


?>