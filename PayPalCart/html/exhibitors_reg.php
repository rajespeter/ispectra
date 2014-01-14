<?php 
require_once '../functions/PP_functions.php';

echo render_header();

$shopping_cart = get_shopping_cart();


if (($_SERVER['REQUEST_METHOD'] == 'GET') && (!empty($_GET['id'])))   
{
    $product_id = $_GET['id'];
            
    if (product_exists($product_id)) 
        {
           $shopping_cart->AddItem($product_id);
        } 
    set_shopping_cart($shopping_cart);  

    if ($product_id == 'EXHIBITOR') {
		 echo render_shopping_cart($shopping_cart); 
		 render_agency_form();  
   }  
    echo "<pre>";
        print_r($product);
        echo "</pre>";  
}       


if (($_SERVER['REQUEST_METHOD'] == 'POST') && (!empty($_POST['register'])))
{
    
    $agency_name = !empty($_POST['agency_name']) ? $_POST['agency_name'] : "";   
    $ag_address_first = !empty($_POST['ag_address1']) ? $_POST['ag_address1'] : "";  
    $ag_address_second = !empty($_POST['ag_address2']) ? $_POST['ag_address2'] : "";     
    $ag_city_name = !empty($_POST['ag_city']) ? $_POST['ag_city'] : "";   
    $ag_state_name = !empty($_POST['ag_state']) ? $_POST['ag_state'] : "";   
    $ag_zip_code = !empty($_POST['ag_zip']) ? $_POST['ag_zip'] : "";   
    $ag_phone_area_code = !empty($_POST['ag_night_phone_a']) ? $_POST['ag_night_phone_a'] : "";   
    $ag_phone_prefix = !empty($_POST['ag_night_phone_b']) ? $_POST['ag_night_phone_b'] : "";
    $ag_phone_postfix = !empty($_POST['ag_night_phone_c']) ? $_POST['ag_night_phone_c'] : "";     
    $ag_email_address = !empty($_POST['ag_email']) ? $_POST['ag_email'] : "";   
    
    $zip_error = (!preg_match('/^\d{5}(?:-\d{4})?$/', $ag_zip_code));
    $email_error = (!preg_match('/\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b/i', $_POST['ag_email']))  ;
    $error_invalid_email = "You have entered and invalid Email address";
    $phone_area_code_error= (!preg_match('/^\d{3}$/', $ag_phone_area_code));
    $phone_prefix_error =  (!preg_match('/^\d{3}$/', $ag_phone_prefix)) ;
    $phone_postfix_error = (!preg_match('/^\d{4}$/', $ag_phone_postfix)) ;
    
    $phone_error = (!preg_match('/^\d{3}$/', $ag_phone_area_code)) || (!preg_match('/^\d{3}$/', $ag_phone_prefix)) || (!preg_match('/^\d{4}$/', $ag_phone_postfix)) ;
           
    
    if (empty($_POST['agency_name']) || 
    empty($_POST['ag_address1']) ||
    empty($_POST['ag_city']) ||
    empty($_POST['ag_state']) ||
    empty($_POST['ag_zip']) ||
    empty($_POST['ag_night_phone_a']) ||
    empty($_POST['ag_night_phone_b']) ||
    empty($_POST['ag_night_phone_c']) ||
    empty($_POST['ag_email']) ||
    ($email_error || $phone_error || $zip_error)) 
   {
 
    echo "<h2  align='center'> Enter the information for Agency or Organization being Registered</h2>";
    echo "<p align='center' class='required'>Please fill in missing or incorrect required * fields</p>";  
    
    $output .= " 
	<div class='section'>
	<form method='post' action='exhibitors_reg.php' id='process registration'>
	
	<table cellpadding='4' align='center'>
	  <tr>
		  <td><label class='required' for='first'>* Agency Name</label></td>
		  <td ><input class='textbox' type='text' name='agency_name' id='agency_name' size='40' value= '$agency_name' /></td>
	  </tr>";
	if(empty($agency_name) ) {$output .= "<tr><td><p class='required' align='center'> 
		Agency or Organization Name is required </p> </td></tr>" ; }                   
   $output .=  " 
	  <tr>
		<td><label class='required' for='address'>* Address Line 1</label></td>
		<td ><input class='textbox' type='text' name='ag_address1' id='ag_address1' size='40' value='$ag_address_first'/></td>
		<td>
	  </tr>
";
if(empty($ag_address_first) ) {$output .= "<tr><td><p class='required' align='center'> Address is required</p> </td></tr>"; }                
 $output .=  "         
	  <tr>
		<td><label class='field' for='address'>&nbsp;&nbsp;Address Line 2</label></td>
		<td ><input class='textbox' type='text' name='ag_address2' id='ag_address2' size='40' value='$ag_address_second'/></td>
	  </tr>
	  <tr>
		<td><label class='required' for='city'>* City</label></td>
		<td ><input class='textbox' type='text' name='ag_city' id='ag_city' size='40' value= '$ag_city_name'/></td>
	  </tr>
  ";
  if(empty($ag_city_name) ) {$output .= "<tr><td> <p class='required' align='center'> City is required </p> </td></tr>"; }                
 $output .=  "         
	  <tr>
		  <td><label class='required' for='state'>* State</label></td>
		  <td >
			  <input class='textbox' type='text' name='ag_state' id='ag_state' size='2' value= '$ag_state_name' />
			  <label class='required' for='zip'>&nbsp;&nbsp;<strong>* Zip</strong>&nbsp;</label>
			  <input class='textbox' type='text' name='ag_zip' id='ag_zip' size='10' value= '$ag_zip_code' />
		  </td>
	  </tr>";

if(empty($ag_state_name) ) {$output .= "<tr><td> <p class='required' align='center'> State is required </p> </td></tr>" ; }                

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
		<input class='textbox' type='text' name='ag_night_phone_a' id='ag_night_phone_a' size='3' value='$ag_phone_area_code'/>
		<input class='textbox' type='text' name='ag_night_phone_b' id='ag_night_phone_b' size='3'value='$ag_phone_prefix' />
		<input class='textbox' type='text' name='ag_night_phone_c' id='ag_night_phone_c' size='4' value='$ag_phone_postfix'/>
	  </td>
	</tr>
		";
if(empty($ag_phone_area_code) || empty($ag_phone_prefix) || empty($ag_phone_prefix)) 
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
			<td ><input class='textbox' type='text' name='ag_email' id='ag_email' size='40' value= '$ag_email_address' /></td>
		</tr>                               
		";
if(isset($ag_email_address) && ($email_error == '1'))
	{
		$output .= "<tr> <td> <label> email address error</label></td>
					<td><p class='required' align='center'> ";
		$output .= $error_invalid_email;
		$output .= "</p> </td> </tr> ";
	}                
 $output .=  " 
	</table>
			<p class='required' align='center'>* Required field.</p>
			<p align='center'><input class='btn' type='submit' name='register' value='Register' />     </p>           
	</form> 
		
	</div> 
	<br />
	";
    echo $output;
    echo render_shopping_cart($shopping_cart); 
    echo "<div class='nav'>
                    <p align='center'><a href='exh_clearCart.php?clear=1'>Cancel and Clear Cart</a></p>
                </div>";      
        
	 }
	 else
	 {
         
    $agency_name = !empty($_POST['agency_name']) ? $_POST['agency_name'] : "";   
    $ag_address_first = !empty($_POST['ag_address1']) ? $_POST['ag_address1'] : "";  
    $ag_address_second = !empty($_POST['ag_address2']) ? $_POST['ag_address2'] : "";     
    $ag_city_name = !empty($_POST['ag_city']) ? $_POST['ag_city'] : "";   
    $ag_state_name = !empty($_POST['ag_state']) ? $_POST['ag_state'] : "";   
    $ag_zip_code = !empty($_POST['ag_zip']) ? $_POST['ag_zip'] : "";   
    $ag_phone_area_code = !empty($_POST['ag_night_phone_a']) ? $_POST['ag_night_phone_a'] : "";   
    $ag_phone_prefix = !empty($_POST['ag_night_phone_b']) ? $_POST['ag_night_phone_b'] : "";
    $ag_phone_postfix = !empty($_POST['ag_night_phone_c']) ? $_POST['ag_night_phone_c'] : "";     
    $ag_email_address = !empty($_POST['ag_email']) ? $_POST['ag_email'] : "";   
                
    $reg_date =  date('m,d,y - H:m:s');
    
	$myFile=LOG_FILE."/e_registration.log";
    echo $myFile;
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
          
             
	  echo "
	<div>
	<div class='section'>
	<form method='post' action='processGroup.php' id='add_names'>
	
	<h4  align='center'> Thank you for completing your Organizational information<br />
		  Please proceed to registering the person attending as your reprsentative</h4>
	<p align='center'><input class='btn' type='submit' name='exhb_complete' value='Add Representative' />     </p>      
		
	<table cellpadding='4' align='center'>

	<tr>
	  <td><label  for='agency'>* Your Agency or Organizations Name</label></td>
	  <td ><input class='textbox' type='text' name='agency_name' id='agency_name' size='25' value= '$agency_name' /></td>
	</tr>
	<tr>
	  <td><label  for='address'>* Address Line 1</label></td>
	  <td ><input class='textbox' type='text' name='ag_address1' id='ag_address1' size='40' value='$ag_address_first'/></td>
	</tr>
	<tr>
	  <td><label class='field' for='address'>&nbsp;&nbsp;Address Line 2</label></td>
	  <td ><input class='textbox' type='text' name='ag_address2' id='ag_address2' size='40' value='$ag_address_second'/></td>
	</tr>
	<tr>
		<td><label  for='city'>* City</label></td>
		<td ><input class='textbox' type='text' name='ag_city' id='ag_city' size='40' value= '$ag_city_name' /></td>
	</tr>
	<tr>
	  <td><label  for='state'>* State</label></td>
	  <td >
		  <input class='textbox' type='text' name='ag_state' id='ag_state' size='2' value= '$ag_state_name' />
		  <label  for='zip'>&nbsp;&nbsp;<strong>* Zip</strong>&nbsp;</label>
		  <input class='textbox' type='text' name='ag_zip' id='ag_zip' size='10' value= '$ag_zip_code' />
	  </td>
	</tr>
	<tr>
	  <td><label  for='phone'>* Phone</label></td>
	  <td >
	  <input class='textbox' type='text' name='ag_night_phone_a' id='ag_night_phone_a' size='3' value='$ag_phone_area_code'/>
	  <label class='field'>&nbsp;&nbsp;</label>
	  <input class='textbox' type='textClear' name='ag_night_phone_b' id='ag_night_phone_b' size='3'value='$ag_phone_prefix' />
		<label class='field'>&nbsp;&nbsp;</label>
		<input class='textbox' type='text' name='ag_night_phone_c' id='ag_night_phone_c' size='4' value='$ag_phone_postfix' />	
	  </td>
	</tr>
	<tr>
	  <td><label  for='email'>* Email Address</label></td>
	  <td ><input class='textbox' type='text' name='ag_email' id='ag_email' size='40' value= '$ag_email_address' /></td>
	</tr>                               
	<tr>                        
	  </tr>
  </table>
	  
	  <p  align='center'>* Required field.</p>
  
  </form> 
				
			</div> 
            
        </div>
        
        ";
     echo render_shopping_cart($shopping_cart);  
     echo "  Or <br/>  
     <p class='nav' align='center'> <a  href='exh_clearCart.php?clear=1'>Cancel and Clear Cart</a></p>    ";   
}
} 
if (($_SERVER['REQUEST_METHOD'] == 'POST') && (!empty($_POST['exhb_complete'])) ) {
	// agency info complete now add people
      echo "    
    <div>
            <div class='section'>
                    <form method='post' action='processGroup.php' id='add_names'>
                    <h2 align='center'> Please fill in information of person registering </h2>
                        <table cellpadding='4' align='center'>
                </tr>  ";   
     
     render_basic_form();
	 echo "  Or <br/>  
     <p class='nav' align='center'> <a  href='exh_clearCart.php?clear=1'>Cancel and Clear Cart</a></p>    ";
    } 

?>

<?php

if (isset($_REQUEST['clear'])) {
    $shopping_cart->EmptyCart();
    echo '<h2>Shopping Cart Emptied!</h2>';
}
set_shopping_cart($shopping_cart);


echo render_footer()
?>
