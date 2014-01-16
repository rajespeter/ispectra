<?php

// enable only one of these depending on if in sandbox or if live
// For testing on with PayPal sandbox on mynetglobal
//require_once ('constants_sandbox.php');

//test on sand box on real site

// For Testing with PayPal real
require_once ('constants_live.php');

/* Database */

// Run the actual connection here  
//mysql_connect("DB_SERVER","DB_USER","DB_PASS") or die ("could not connect to mysql");
//mysql_select_db("DB_NAME") or die ("no database");    


$mysqli = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);


// Define references
require_once ('PP_templates.php');

require_once('../classes/ShoppingCart.php');


// Functions
session_start();

function get_products(){
    global $mysqli;
    $result = $mysqli->query("SELECT * FROM products");
    
    if ($result->num_rows > 0)
    {
        $row_num = 0;
        while ($row = $result->fetch_object())
        {
            //$product[$row_num]['id'] = $row->id;
            $products[$row_num]['id'] = $row->product_name;  //remember to use  product_name in mySQL queries in place of id
            $products[$row_num]['price'] = number_format($row->price, 2);
            $products[$row_num]['details'] = $row->details;
            $products[$row_num]['category'] = $row->category;
            $products[$row_num]['subcategory'] = $row->subcategory;
            $products[$row_num]['date_added'] = $row->date_added;
            $row_num++;
        }
        
        return $products;
    }
    else
    {
        return FALSE;
    }
}


function get_xml_catalog() {
    return new SimpleXMLElement(file_get_contents(REGULAR_XML_FILE));
}

function product_exists_XML($product_id){
    //foreach(get_xml_catalog() as $product) 
    foreach(get_products() as $product) 
    {
        if ($product->id == $product_id) {
            echo "true";
            return true;
        }                   
    }
    return false;
}

function product_exists($product_id)
{
    global $mysqli;
    if ($stmt = $mysqli->prepare("SELECT product_name FROM products WHERE product_name = ?"))//remembered to use  product_name in mySQL queries in place of id
    {
        $stmt->bind_param("s", $product_id);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    else
    {
        throw new Exception('Could not prepare MySQLi statement.');
    }
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
    global $mysqli;
    if ($stmt = $mysqli->prepare("SELECT price FROM products WHERE product_name = ?"))//remembered to use  product_name in mySQL queries in place of id
    {
        $stmt->bind_param("s", $product_id);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0)
        {
            $stmt->bind_result($price);
            $stmt->fetch();
            return number_format($price, 2);
        }
        else
        {
            throw new Exception('Product not found!');
        }
    }
    else
    {
        throw new Exception('Could not prepare MySQLi statement.');
    }
}

/*
function get_item_cost($product_id) {
    //foreach(get_xml_catalog() as $product) 
    foreach(get_products() as $product) 
    {
        if ($product_id == $product->id) 
            return $product->price;
        
    }
    throw new Exception('item not found: ' . $product_id);
    
} */

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

function add_etrain(){
    $product_id =    'ETRAIN';
    $shopping_cart->AddItem($product_id);
    set_shopping_cart($shopping_cart);  
    
}
function get_coupon($codes){ //not using this anymore

	if (empty($codes))
	{
		 return(-1);
	}
	else {
		
	
	$ids = implode("','", $codes)  ;  
 		
    $sql = "SELECT value, code FROM coupon WHERE value = (  SELECT MAX( value ) FROM coupon WHERE code IN ('$ids'))";
	error_log($sql);// $sql) ;//remove later
    global $mysqli;
	  if ($stmt = $mysqli->prepare($sql))// 
     {
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0)
        {
            $stmt->bind_result($value ,$code);
		 
			 
            $stmt->fetch();
			$code_val[1]['value'] = $value;//number_format($value, 2);
            $code_val[1]['code'] = $code;
		 
            return $code_val;
        }
        else
        {
            return null;
        }
    }
    else
    {
        throw new Exception('Could not prepare MySQLi statement.');
    }
	}
}
function valid_coupon($codes){
	

	if ($codes=="")
	{
		 return(-1);
	}
	else {
 		
    $sql = "SELECT value, code FROM coupon WHERE code ='".$codes."'";
	error_log($sql);// $sql) ;//remove later
    global $mysqli;
	  if ($stmt = $mysqli->prepare($sql))
     {
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0)
        {
            $stmt->bind_result($value ,$code);
		 
			 
            $stmt->fetch();
			$code_val[1]['value'] = $value;//number_format($value, 2);
            $code_val[1]['code'] = $code;
		 
            return $code_val;
        }
        else
        {
            return -1;
        }
    }
    else
    {
        throw new Exception('Could not prepare MySQLi statement.');
    }
	}
}


function insert_register($reg_row){
	

 
    $id = "'".str_replace("~","','",$reg_row) ."'";//this will break if they enter a , some where
    $sql ="INSERT INTO `register`( `first_name`,
                       `last_name`, 
                       `contact_number`,
                       `address1`,
                       `address2`, 
                       `city`, 
                       `zip`, 
		               `country`, 
                       `email`, 
                       `etrain`, 
                       `adult`, 
                       `church`, 
                       `coupon`, 
                       `ethinicity`, 
                       `primary_language`,
                       `secondary_language`, 
                       `trans_language`, 
                       `comments` ,
                       `gcode`) VALUES ($id)";
	  
	error_log($sql);// $sql) ;//remove later
	//echo $sql;
    global $mysqli;
	if ($stmt = $mysqli->prepare($sql))
     {
        $stmt->execute();
        $stmt->store_result();
        
       
		/* close statement and connection */
		$stmt->close();

		/* close connection */
		//$mysqli->close();
    }
    else
    {
        error_log('Could not prepare MySQLi statement.');
    }
	}
 

?>