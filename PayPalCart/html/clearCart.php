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
     $complete = !empty($_GET['complete']) ? $_GET['complete'] : "";
 	if ($complete=="2")
	{
		$gcode = $shopping_cart->GetGcode() ;
		$quantity1 = $shopping_cart->GetItemQuantity();
		
		insert_ipn($gcode,$quantity1,0);//capture the group code in the db to track valid registerants
		
	}     
	
    $shopping_cart->EmptyCart();
  	set_shopping_cart($shopping_cart);
	

redirect_to("../../registration.php?complete=1");  
}






?>





?>
