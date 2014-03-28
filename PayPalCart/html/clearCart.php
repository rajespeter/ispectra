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
		
		insert_ipn($gcode,1,0);//capture the group code in the db to track valid registerant , there is a bug if multiple free
		//registerants then the count is wrong
		$headers = "From: register@ispectraignite.org\r\n";
		$headers .= "Reply-To: register@ispectraignite.org\r\n";
		$headers .= "X-Mailer: PHP/".phpversion();
		$message .=  "\n\nA new but Complimentary  registration Verified OK ";
		//$message .=  "\n\n".$req;
		$message .=  "\n\n gcode  :".$gcode;
	 //  mail('rajeshpeter@gmail.com,tadcooper4@gmail.com,pastorjp@ispectraignite.org,dlindert@yahoo.com', 'IPN iSpectra', $message,$headers);
	    mail('rajeshpeter@gmail.com', 'IPN iSpectra', $message,$headers);
		
	}     
	
    $shopping_cart->EmptyCart();
  	set_shopping_cart($shopping_cart);
	

redirect_to("../../registration.php?complete=1");  
}






?>





?>
