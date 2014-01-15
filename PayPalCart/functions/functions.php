<?php

// enable only one of these depending on if in sandbox or if live
// For testing on with PayPal sandbox on mynetglobal
//require_once ('constants_sandbox.php');

//test on sand box on real site

// For Testing with PayPal real
//require_once ('constants_live.php');

// Define references
require_once ('templates.php');

require_once('../classes/ShoppingCart.php');


// Functions
session_start();
 
if(isset($_SESSION['gcode']) && !empty($_SESSION['gcode'])) 
{
   $_SESSION['gcode']=rand(1,100);
   echo "session". $_SESSION['gcode'];
}
 

function get_xml_catalog() {
    return new SimpleXMLElement(file_get_contents(REGULAR_XML_FILE));
    return new SimpleXMLElement(file_get_contents(EXHIBITORS_XML_FILE));
    return new SimpleXMLElement(file_get_contents(GROUP_XML_FILE));
}

function product_exists($product_id){
    foreach(get_xml_catalog() as $product) 
    {
        if ($product->id == $product_id) {
            return true;
        }                   
    }
    return false;
}

function get_shopping_cart() {
    if (! isset($_SESSION['cart'])) {
        return new ShoppingCart();
    } else {
        return unserialize($_SESSION['cart']);
    }
}

function set_shopping_cart($cart) {
    $_SESSION['cart'] = serialize($cart);
}

function get_item_cost($product_id) 
{
    foreach(get_xml_catalog() as $product) 
    {
        if ($product_id == $product->id) 
            return $product->price;
        
    }
    throw new Exception('item not found: ' . $product_id);
    
}

function redirect_to( $location = NULL ) {
  if($location != NULL) {
    header("Location: {$location}");
    exit;
  } 
}
function add_recording(){
    $product_id =    'RECORDINGS';
    $shopping_cart->AddItem($product_id);
    set_shopping_cart($shopping_cart);  
    
}

?>