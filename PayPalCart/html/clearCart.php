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
	

$headers = "From: peter@example.com\r\n";
$headers .= "Reply-To: peter@example.com\r\n";
$headers .= "X-Mailer: PHP/".phpversion();
// compose message
$message = "we have a succesfull registration ";
$message .= " on." .    date('m-d-y - H:m:s');


// make sure each line doesn't exceed 70 characters
$message = wordwrap($message, 70);

// send email
mail('rajeshpeter@gmail.com', 'Registration Recived', $message,$headers);


redirect_to("../../registration.php?complete=1");  
}






?>
