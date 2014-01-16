<?php 
require_once '../functions/PP_functions.php';
ob_start();  

$shopping_cart = get_shopping_cart();

if (isset($_REQUEST['clear'])) {
    $shopping_cart->EmptyCart();
    echo '<h2>Shopping Cart Emptied!</h2>';
	set_shopping_cart($shopping_cart);
	redirect_to("../../registration.php?clear=1");  
}

if (isset($_REQUEST['complete'])) {
    $shopping_cart->EmptyCart();
    echo '<h2>Transaction Completed!</h2>';
	set_shopping_cart($shopping_cart);
	mail("rajeshpeter@gmail.com", "REGISTRATION DONE", "REGISTRATION DONE", "From: rajeshpeter@yahoo.com" );
	redirect_to("../../registration.php?complete=1");
}






?>
