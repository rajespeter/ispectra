<?php
ob_start(); 
require_once '../functions/PP_functions.php';

$shopping_cart = get_shopping_cart();
$name_List=array();   
?>

<?= render_header(); ?>

<?php 
    $first_name = !empty($_POST['first']) ? $_POST['first'] : "";  
    $last_name = !empty($_POST['last']) ? $_POST['last'] : "";  
    $address_first = !empty($_POST['address1']) ? $_POST['address1'] : "";  
    $address_second = !empty($_POST['address2']) ? $_POST['address2'] : "";     
    $city_name = !empty($_POST['city']) ? $_POST['city'] : "";   
    $state_name = !empty($_POST['state']) ? $_POST['state'] : "";   
    $zip_code = !empty($_POST['zip']) ? $_POST['zip'] : "";   
    $phone_area_code = !empty($_POST['night_phone_a']) ? $_POST['night_phone_a'] : "";   
    $phone_prefix = !empty($_POST['night_phone_b']) ? $_POST['night_phone_b'] : "";
    $phone_postfix = !empty($_POST['night_phone_c']) ? $_POST['night_phone_c'] : "";     
    $email_address = !empty($_POST['email']) ? $_POST['email'] : "";   
    
    $zip_error = (!preg_match('/^\d{5}(?:-\d{4})?$/', $zip_code));
    $email_error = ((!preg_match('/\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b/i', $_POST['email'])) || empty($_POST['email']))  ;
    $error_invalid_email = "You have not entered an email address or entered an invalid Email address";
    $phone_area_code_error= (!preg_match('/^\d{3}$/', $phone_area_code));
    $phone_prefix_error =  (!preg_match('/^\d{3}$/', $phone_prefix)) ;
    $phone_postfix_error = (!preg_match('/^\d{4}$/', $phone_postfix)) ;
    
    $phone_error = (!preg_match('/^\d{3}$/', $phone_area_code)) || (!preg_match('/^\d{3}$/', $phone_prefix)) || (!preg_match('/^\d{4}$/', $phone_postfix)) ;
    
  
if (isset($_POST['submit']))
{
    if (empty($_POST['first']) || 
    empty($_POST['last']) ||
    empty($_POST['address1']) ||
    empty($_POST['city']) ||
    empty($_POST['state']) ||
    empty($_POST['zip']) ||
    empty($_POST['night_phone_a']) ||
    empty($_POST['night_phone_b']) ||
    empty($_POST['night_phone_c']) ||
    ($email_error || $phone_error || $zip_error)) 
   {
    
    
 
    echo "<h2> Enter the information for person paying</h2>";
    echo "<p align='center' class='required'>Please fill in missing or incorrect required * fields</p>";  
    
    $output .= " <div class='section'>
            <form method='post' action='specialOrder.php' id='place_order'>
            
                <table cellpadding='4' align='center'>
                    <tr>
                        <td><label class='required' for='first'>* First Name</label></td>
                        <td ><input class='textbox' type='text' name='first' id='first' size='40' value= '$first_name' /></td>
                    </tr>";
            if(empty($first_name) ) {$output .= '<tr><td> <p class=\'required\' align=\'center\'> First Name is required </p> </td></tr>' ; }                   
             $output .=  " 
                    
                    <tr>
                        <td><label class='required' for='last'>* Last Name</label></td>
                        <td ><input class='textbox' type='text' name='last' id='last' size='40' value= '$last_name' /></td>
                       </tr>  ";
            if(empty($last_name) ) {$output .= '<tr><td> <p class=\'required\' align=\'center\'> Last Name is required </p> </td></tr>' ; }                
             $output .=  " 
                       
                    <tr>
                        <td><label class='required' for='address'>* Address Line 1</label></td>
                        <td ><input class='textbox' type='text' name='address1' id='address1' size='40' value= '$address_first' /></td>
                        <td>
                    </tr>
            ";
            if(empty($address_first) ) {$output .= '<tr><td> <p class=\'required\' align=\'center\'> Address is required </p> </td></tr>' ; }                
             $output .=  "         
                    <tr>
                        <td><label class='field' for='address'>&nbsp;&nbsp;Address Line 2</label></td>
                        <td ><input class='textbox' type='text' name='address2' id='address2' size='40' value= '$address_second' /></td>
                    </tr>
                    <tr>
                        <td><label class='required' for='city'>* City</label></td>
                        <td ><input class='textbox' type='text' name='city' id='city' size='40' value= '$city_name' /></td>
                    </tr>
              ";
            if(empty($city_name) ) {$output .= '<tr><td> <p class=\'required\' align=\'center\'> City is required </p> </td></tr>' ; }                
             $output .=  "         
                    <tr>
                        <td><label class='required' for='state'>* State</label></td>
                        <td >
                            <input class='textbox' type='text' name='state' id='state' size='2' value= '$state_name' />
                            <label class='required' for='zip'>&nbsp;&nbsp;<strong>* Zip</strong>&nbsp;</label>
                            <input class='textbox' type='text' name='zip' id='zip' size='10' value= '$zip_code' />
                        </td>
                    </tr>";
           
            if(empty($state_name) ) {$output .= '<tr><td> <p class=\'required\' align=\'center\'> State is required </p> </td></tr>' ; }                
            
            if($zip_error == '1')
                {
                    $output .= "<tr> <td> <label> Zip code error </label></td>
                                <td><p class='required' align='center'> ";
                    $output .= "Zip code is not in correct format or is missing";
                    $output .= "</p> </td> </tr>";
                }               
             $output .=  " 
                    <tr>
                        <td><label class='required' for='phone'>* Phone</label></td>
                        <td >
                        <input class='textbox' type='text' name='night_phone_a' id='night_phone_a' size='3' value= '$phone_area_code' />
                        <input class='textbox' type='text' name='night_phone_b' id='night_phone_b' size='3'value= '$phone_prefix'  />
                        <input class='textbox' type='text' name='night_phone_c' id='night_phone_c' size='4' value= '$phone_postfix' /></td>
                    </tr>
                    ";
            if(empty($phone_area_code) || empty($phone_prefix) || empty($phone_prefix)) 
                {
                    $output .= "<tr> <td> <label> phone number error </label></td>
                                <td><p class='required' align='center'> ";
                    $output .= "Please fill in missing numbers";
                    $output .= "</p> </td> </tr>";
                }  
            
            if($phone_area_code_error == '1')
                {
                    $output .= "<tr> <td> <label> phone number error </label></td>
                                <td><p class='required' align='center'> ";
                    $output .= "Area Code requires 3 Numbers";
                    $output .= "</p> </td> </tr>";
                }  
                if($phone_prefix_error == '1')
                {
                    $output .= "<tr> <td> <label> phone number error </label></td>
                                <td><p class='required' align='center'> ";
                    $output .= "Phone prefix requires 3 Numbers";
                    $output .= "</p> </td> </tr>";
                } 
                if($phone_postfix_error == '1')
                {
                    $output .= "<tr> <td> <label> phone number error </label></td>
                                <td><p class='required' align='center'> ";
                    $output .= "Phone post requires 4 Numbers ";
                    $output .= "</p> </td> </tr>";
                }               
             $output .=  " 
                    
                    <tr>
                        <td><label class='required' for='email'>* Email Address</label></td>
                        <td ><input class='textbox' type='text' name='email' id='email' size='40' value= '$email_address' /></td>
                    </tr>                               
                    ";
            if(isset($email_address) && ($email_error == '1'))
                {
                    $output .= "<tr> <td> <label> email address error</label></td>
                                <td><p class='required' align='center'> ";
                    $output .= $error_invalid_email;
                    $output .= "</p> </td> </tr> ";
                }                
             $output .=  " 
                </table>
                    <p class='required' align='center'>* Required field.</p>
                    <p align='center'><input class='btn' type='submit' name='submit' value='SUBMIT ORDER' />     </p>           
            </form> 
                
            </div> 
            <br />
            ";
    echo $output;
    echo render_shopping_cart($shopping_cart); 
    $name_List=$shopping_cart->listNames();
           print_r($name_List);
    echo "<div class='nav'>
                    <p align='center'><a href='clearCart.php?clear=1'>Cancel and Clear Cart</a></p>
                </div>";      
         
   }  
   else 
   {
       
      
       echo "<h2> Person Paying</h2>";
       echo render_paypal_checkout($shopping_cart) ;
       $name_List=$shopping_cart->listNames();
           print_r($name_List);
       echo "<div class='nav'>
                    <p align='center'><a href='clearCart.php?clear=1'>Cancel and Clear Cart</a></p>
                </div>";  
                
    $full_address .=   $_POST['address1'];
    if (isset($_POST['address2']) ) {$full_address .= "," . $_POST['address2']; } 
    $full_phone_number = $_POST['night_phone_a'] . "-" . $_POST['night_phone_b'] . "-" . $_POST['night_phone_c'];
    $reg_date =  date('m,d,y - H:m:s');
    
    $myFile="./order.log";
    $fh = fopen($myFile, 'a') or die("can't open file");
    
    $v = "["  . $reg_date  . "],  " . $_POST['first'] . " " . $_POST['last']  . " , " . $full_address . " , " . $_POST['city'] . ", " . $_POST['state'] . ", " . $_POST['zip']   . " , " . $full_phone_number . " , "  . $_POST['email'] . "\n"; 
    
            
    fwrite($fh, $v);
    fclose($fh);
   }
  
}
else 
{
    if (($_SERVER['REQUEST_METHOD'] == 'GET') && (($_GET['id'] == 'HOST') || ($_GET['id'] == 'VOLUNTEER'))) {
    $product_id = $_GET['id'];
        
    $shopping_cart->AddItem($product_id);
    set_shopping_cart($shopping_cart);    
    echo $product_id;
    }
   
    echo "<h2> Enter the information for person paying</h2>";
    echo render_input_form_check();
    
    echo render_shopping_cart($shopping_cart);  
    
    $name_List=$shopping_cart->listNames();
           print_r($name_List);
    
     
    echo "<div class='nav'>
                    <p align='center'><a href='clearCart.php?clear=1'>Cancel and Clear Cart</a></p>
                </div>";	
} 

?>
<!--
<div class='nav'>
            If correct <a href='placeOrder'>Place Order</a>
</div>
-->

<?= render_footer(); ?>
