<?php
ob_start(); 
require_once '../functions/PP_functions.php';

$shopping_cart = get_shopping_cart();
   
echo  render_header(); 

?>

<?php

$name_list=array();
   
if (($_SERVER['REQUEST_METHOD'] == 'POST') && (!empty($_POST['action'])))
{
    $reg_date =  date('m,d,y - H:m:s');
    $myFile="./registration.log";
    $fh = fopen($myFile, 'a') or die("can't open file");
    
    $v = "["  . $reg_date  . "],  " 
    .$_REQUEST['agency_name'] . ",  " 
    .$_REQUEST['ag_address1'] . ",  " 
    . $_REQUEST['ag_address2'] . " , " 
    . $_REQUEST['ag_city'] . " , " 
    . $_REQUEST['ag_state'] . " , " 
    . $_REQUEST['ag_zip'] . " , " 
    . $_REQUEST['ag_night_phone_a'] . "-" . $_REQUEST['ag_night_phone_b'] . "-" . $_REQUEST['ag_night_phone_c'] . " , " 
    . $_REQUEST['ag_email'] . " , " 
    .$_REQUEST['first_name'] . ",  "
     . $_REQUEST['last_name'] . " , "
    . $_REQUEST['adultchild'] . " , " 
    . $_REQUEST['email'] . " , " 
    . $_REQUEST['recordings'] ."\n"; 
    
    
    fwrite($fh, $v);
    fclose($fh);
         
    
    $checked = "checked";
    $email_error = ((!preg_match('/\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b/i', $_POST['email'])) || empty($_POST['email']))  ;
    $error_invalid_email = "You have not entered an email address or entered an invalid Email address";
    
    
    $first_name = !empty($_POST['first_name']) ? $_POST['first_name'] : "";  
    $last_name = !empty($_POST['last_name']) ? $_POST['last_name'] : ""; 
    $address_first = !empty($_POST['address1']) ? $_POST['address1'] : "";  
    $address_second = !empty($_POST['address2']) ? $_POST['address2'] : "";     
    $city_name = !empty($_POST['city']) ? $_POST['city'] : "";   
    $state_name = !empty($_POST['state']) ? $_POST['state'] : "";   
    $zip_code = !empty($_POST['zip']) ? $_POST['zip'] : "";    
    $email_address = !empty($_POST['email']) ? $_POST['email'] : "";
    $adult_child = !empty($_POST['adultchild']) ? $_POST['adultchild'] : "";
    $recordings = !empty($_POST['recordings']) ? $_POST['recordings'] : "";
    $church = !empty($_POST['church']) ? $_POST['church'] : "";
    
    $full_name= $first_name . " " . $last_name;
    $zip_error = (!preg_match('/^\d{5}(?:-\d{4})?$/', $zip_code));
            
    if (empty($_POST['first_name']) || 
        empty($_POST['last_name']) ||
        ($email_error == '1')) 
       {
           
            $output .= "<p align='center' class='required'>Please fill in missing required * fields</p>";  
           
            
            $output .= "         <div class='form'>
                    <form method='post' action='specialGroup.php' id='peoples_names'>
                    <table cellpadding='4'>
                       <tr>
                        <td><label class='required' for='first_name'>* First Name</label></td>
                        <td ><input class='textbox' type='text' name='first_name' id='first_name' size='30' value= '$first_name' /></td>
                       <td>";
            if(empty($first_name) ) {$output .= 'Name is required '; }                
             $output .=  " </td>
                        </tr>
                         <tr>
                            <td><label class='required' for='last_name'>* Last Name</label></td>
                            <td><input class='textbox' type='text' name='last_name' id='last_name' size='30' value= '$last_name'/></td>
                            <td>";
            if(empty($last_name) ) {$output .= 'Name is required '; }                
             $output .=  " </td>
                            </tr>
                     <tr>
                        <td><label class='field' for='address'> Address Line 1</label></td>
                        <td ><input class='textbox' type='text' name='address1' id='address1' size='40' value= '$address_first' /></td>
                        <td>
                    </tr>
                  
                    <tr>
                        <td><label class='field' for='address'>&nbsp;&nbsp;Address Line 2</label></td>
                        <td ><input class='textbox' type='text' name='address2' id='address2' size='40' value= '$address_second' /></td>
                    </tr>
                    <tr>
                        <td><label class='field' for='city'> City</label></td>
                        <td ><input class='textbox' type='text' name='city' id='city' size='40' value= '$city_name' /></td>
                    </tr>
                    
                    <tr>
                        <td><label class='field' for='state'> State</label></td>
                        <td >
                            <input class='textbox' type='text' name='state' id='state' size='2' value= '$state_name' />
                            <label class='field' for='zip'>&nbsp;&nbsp;<strong> Zip</strong>&nbsp;</label>
                            <input class='textbox' type='text' name='zip' id='zip' size='10' value= '$zip_code' />
                        </td>
                    </tr>";
            
            if(!empty($zip_code) && ($zip_error == '1'))
                {
                    $output .= "<tr> <td> <label> Zip code error </label></td>
                                <td><p class='required' align='center'> ";
                    $output .= "Zip code is not in correct format or is missing";
                    $output .= "</p> </td> </tr>";
                }               
                            
                $output .= "            
                          <tr>
                                <td ><label class='required' for='email'>* Email Address</label></td>
                                <td><input class='textbox' type='text' name='email' id='email' size='40' value= '$email_address'/></td>
                                <td> &nbsp;<br /> &nbsp; 
                                </td></tr>
                                ";
            if($email_error == '1')
                {
                    $output .= "<tr> <td> <label> email address error</label></td>
                                <td><p class='required' align='center'> ";
                    $output .= $error_invalid_email;
                    $output .= "</p> </td> ";
                }                
             
                $output .=  "
                 </td>                          
                    </tr>
                    <tr>
                        <td><label class='field' for='church'> Your Church or Organization Name and City </label></td>
                        <td ><input class='textbox' type='text' name='church' id='church' size='50' value= '' /></td>
                    </tr> 
                    
                    
                        </table>
                            <p class='required' align='center'>* Required field.</p>
                            <p align='center'><input class='btn' type='submit' name='action' value='Add this Person to Registration' />     </p>
                    </form>
                    <p align='center'>Or </p>
                    
                    <p class='nav' align='center'><a href='clearCart.php?clear=1'>Cancel and Clear Cart</a><br /></p>
                    
                </div>
                 
        
                    <br />
                    ";
            echo $output;
        }
        else
        {
            
            echo $full_name . "<br/>";
            $num=$shopping_cart->addNames($full_name);
            echo $num . "<br/>";
            set_shopping_cart($shopping_cart);
            echo render_shopping_cart($shopping_cart);  
             $output .= "<div class='nav' align='center'>
                    <a href='specialOrder.php'>Go to Checkout</a> 
                    </div>"; 
            $product_id='';  
            $test_id = $shopping_cart->CheckItem($product_id = "HOST");
            if ( $test_id)     
                 {$product_id='HOST';
                }  
                else 
                {
                $test_id = $shopping_cart->CheckItem($product_id = "VOLUNTEER");
                    if ( $test_id)   {$product_id='VOLUNTEER';}  
                }  
                
            $output .= " <h2 align='center'> Or add  another person to register </h2> 
                <div class='nav' align='center'>  
                <a href='specialGroup.php?id=$product_id'> Add Person </a>
                <p align='center'> Or </p>
                    <a href='clearCart.php?clear=1'>Cancel and Clear Cart</a>
               </div>"; 
            echo $output;
           
           $name_List=$shopping_cart->listNames();
           print_r($name_List);
            
        }
}
 
if (($_SERVER['REQUEST_METHOD'] == 'GET') && (empty($_GET['id'])))  {
   echo "    
    <div>
            <div class='section'>
                    <form method='post' action='processGroup.php' id='add_names'>
                    <h2 align='center'> Please fill in information of person registering </h2>
                        <table cellpadding='4' align='center'>
                </tr>  ";   
     
     render_basic_form();  
}    
 if (($_SERVER['REQUEST_METHOD'] == 'GET') && (($_GET['id'] == 'HOST') || ($_GET['id'] == 'VOLUNTEER'))) {
    $product_id = $_GET['id'];
        
    $shopping_cart->AddItem($product_id);
    set_shopping_cart($shopping_cart);    
    echo $product_id;
    
    echo "    
    <div>
            <div class='section'>
                    <form method='post' action='specialGroup.php' id='add_names'>
                    <h2 align='center'> Please fill in information of person registering </h2>
                        <table cellpadding='4' align='center'>
                </tr>  ";   
     
     render_special_form();  
    echo render_shopping_cart($shopping_cart);  
     
    echo "<div class='nav'>
                    <p align='center'><a href='clearCart.php?clear=1'>Cancel and Clear Cart</a></p>
                </div>";   
   } 
?>

<?php
echo render_footer()
?>

