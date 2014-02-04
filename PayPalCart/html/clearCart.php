<?php 
ob_start();
require_once '../functions/PP_functions.php';
  

$shopping_cart = get_shopping_cart();

if (isset($_REQUEST['clear'])) {
    $shopping_cart->EmptyCart();
	set_shopping_cart($shopping_cart);
	redirect_to("../../registration.php?clear=1");  
}

if (isset($_REQUEST['complete'])) {
    $shopping_cart->EmptyCart();
  	set_shopping_cart($shopping_cart);
	

redirect_to("../../registration.php?complete=1");  
}






?>





?>
