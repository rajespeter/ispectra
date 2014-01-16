<?php

// This file is www.developphp.com curriculum material
// Written by Adam Khoury January 01, 2011
// http://www.youtube.com/view_play_list?p=442E340A42191003
// Check to see there are posted variables coming into the script
if ($_SERVER['REQUEST_METHOD'] != "POST") die ("No Post Variables");

// Initialize the $req variable and add CMD key value pair
$req = 'cmd=_notify-validate';
// Read the post from PayPal
foreach ($_POST as $key => $value) {
    $value = urlencode(stripslashes($value));
    $req .= "&$key=$value";
}
// Now Post all of that back to PayPal's server using curl, and validate everything with PayPal
// We will use CURL instead of PHP for this for a more universally operable script (fsockopen has issues on some environments)
$url = "https://www.sandbox.paypal.com/cgi-bin/webscr";

//$url = "https://www.paypal.com/cgi-bin/webscr";

$curl_result=$curl_err='';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded", "Content-Length: " . strlen($req)));
curl_setopt($ch, CURLOPT_HEADER , 0);   
curl_setopt($ch, CURLOPT_VERBOSE, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
$curl_result = @curl_exec($ch);
$curl_err = curl_error($ch);
curl_close($ch);

$req = str_replace("&", "\n", $req);  // Make it a nice list in case we want to email it to ourselves for reporting
error_log("ipn request". $req);

// Check that the result verifies
if (strpos($curl_result, "VERIFIED") !== FALSE) {
    $req .= "\n\nPaypal Verified OK";
    mail("dlindert@yahoo.com", "IPN interaction verified", "$req", "From: dlindert@yahoo.com" );
} else {
    $req .= "\n\nData NOT verified from Paypal!";
    mail("dlindert@yahoo.com", "IPN interaction not verified", "$req", "From: dlindert@yahoo.com" );
    exit();
}

//this is from the other course on save the stuff into a log file

   $myFile=LOG_FILE."/payments.log";
		 
    $fh = fopen($myFile, 'a') or die("can't open file");
    
    $v =  $_POST['txn_id'] . $_POST['payment_status'] . " : [" . $_POST['payment_date'] . "] : "  . " subtotal:" . $_POST['mc_gross'] . $_POST['payer_email'] . "\n"; 
    
    fwrite($fh, $v);
    fclose($fh);
?>