<?php
ob_start(); 
require_once '../functions/PP_functions.php';

$shopping_cart = get_shopping_cart();
   
echo  render_header(); 

?>

<?php

//first time start of registration start here, to fill in basic form
 
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

    
if (($_SERVER['REQUEST_METHOD'] == 'POST') && (!empty($_POST['action'])))
{	// check to see if form is complete, repeat until all required items are complete and correct
    $checked = "checked";
    $email_error = (!preg_match('/\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b/i', $_POST['email']))  ;
    $error_invalid_email = "You have entered and invalid Email address";
    
    $first_name = !empty($_POST['first_name']) ? $_POST['first_name'] : "";  
    $last_name = !empty($_POST['last_name']) ? $_POST['last_name'] : ""; 
    $contact_number = !empty($_POST['contact_number']) ? $_POST['contact_number'] : ""; 
    $address_first = !empty($_POST['address1']) ? $_POST['address1'] : "";  
    $address_second = !empty($_POST['address2']) ? $_POST['address2'] : "";     
    $city_name = !empty($_POST['city']) ? $_POST['city'] : "";   
    $state_name = !empty($_POST['state']) ? $_POST['state'] : "";   
    $zip_code = !empty($_POST['zip']) ? $_POST['zip'] : "";    
    $email_address = !empty($_POST['email']) ? $_POST['email'] : "";
    $adult_child = !empty($_POST['adultchild']) ? $_POST['adultchild'] : "";
    $recordings = !empty($_POST['recordings']) ? $_POST['recordings'] : "";
    $church = !empty($_POST['church']) ? $_POST['church'] : "";
	$t_coupon= !empty($_POST['t_coupon']) ? $_POST['t_coupon'] : "";
	$ethinicity= !empty($_POST['ethinicity']) ? $_POST['ethinicity'] : "";
	$primary_language= !empty($_POST['primary_language']) ? $_POST['primary_language'] : "";
	$secondary_language= !empty($_POST['secondary_language']) ? $_POST['secondary_language'] : "";
	$trans_language= !empty($_POST['trans_language']) ? $_POST['trans_language'] : "";
	$comments= !empty($_POST['comments']) ? $_POST['comments'] : "";
	
 
    
    $zip_error = (!preg_match('/^\d{5}(?:-\d{4})?$/', $zip_code));
   	$coutput = countryArray("", "");
	
	//check to see if all required items in form are complete and correct.       
    if (empty($_POST['first_name']) || 
        empty($_POST['last_name']) ||
        empty($_POST['contact_number'])||
        empty($_POST['adultchild']) ||
        (!empty($_POST['email']) && ($email_error == '1'))) 
       {
           
	  $output .= "<p align='center' class='required'>Please fill in missing required * fields</p>";  
	 
	  $output .= "         <div class='form'>
			  <form method='post' action='processGroup.php' id='peoples_names'>
			  <table cellpadding='4'>
			 <tr>
			  <td><label class='required' for='first_name'>* First Name</label></td>
			  <td ><input class='textbox' type='text' name='first_name' id='first_name' size='30' 
			  	value= '$first_name' /></td>
			 </tr>
			 <tr>
			  <td><label class='required' for='last_name'>* Last Name</label></td>
			  <td><input class='textbox' type='text' name='last_name' id='last_name' size='30' 
			  	value= '$last_name'/></td>
			  	</tr>
				
			<tr>     
			  <td><label  class='required' for='contact_number'>* Contact Number</label></td>
			  <td > <input class='textbox' type='text' name='contact_number' id='contact_number' size='30' 
			  value= '$contact_number' />
			   </td>
			</tr>
		  
	   		<tr>
			   <tr>
				  <td><label class='field' for='address'> Address Line 1</label></td>
				  <td ><input class='textbox' type='text' name='address1' id='address1' size='40' 
				  	value= '$address_first' /></td>
				  <td>
			  </tr>
			  <tr>
				  <td><label class='field' for='address'>&nbsp;&nbsp;Address Line 2</label></td>
				  <td ><input class='textbox' type='text' name='address2' id='address2' size='40' 
				  	value= '$address_second' /></td>
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
			  </tr> 
			   <tr>
				  <td>
				  <label class='field' for='Country'> Country</label></td>
				  <td align='left' class='field' >$coutput		  
				  </td>
			  </tr>	  
			  <tr>
				  <td><label class='field' for='church'>Church,Organization Name</label></td>
				  <td ><input class='textbox' type='text' name='church' id='church' size='50' value= '' /></td>
			  </tr> 
			  <tr>     
				  <td><label class='field' for='recordings'>Add Ethnic Training for $30 </label></td>
				  <td > <input class='' type='checkbox' name='recordings' id='recordings' size='25' value= 'RECORDINGS' "; 
		   			if (!empty($recordings)) {$output .=  $checked;}
		  			$output .=  "
		  			/></td>                          
		  		</tr>
			
		      <tr>
				  <td ><label class='field' for='email'> Email Address</label></td>
				  <td><input class='textbox' type='text' name='email' id='email' size='40' value= '$email_address'/>
				  </td>
			  </tr>
				  	   <input type='hidden' name='adultchild' id='adultchild' value= 'ADULT' />
				  
			  <!--tr> 
				 <td><label class='required' for='adultchild'>*  Adult or Child (Grades 1-6)  </label></td>
				  <td align='left'>Adult<input class='radio' type='radio' name='adultchild' id='adulttype' value='ADULT' "; 
		   if (!empty($adult_child) && ($adult_child =='ADULT')) {$output .=  $checked;}
		  $output .=  "/> &nbsp;&nbsp;&nbsp;Child<input class='radio' type='radio' name='adultchild' id='childtype' value= 'CHILD' "; 
		   if (!empty($adult_child) && ($adult_child =='CHILD')) {$output .=  $checked;}
		  $output .= "/>
		   </td>                          
			  </tr-->
			  <tr>     
				  <td><label  class='field' for='ethinicity'>Ethinicity</label></td>
				  <td > <input class='textbox' type='text' name='ethinicity' id='ethinicity' size='30' value= '$ethinicity' /></td>
			  </tr>
			  <tr>     
				  <td><label   class='field' for='primary_language'>Primary Language</label></td>
				  <td > <input class='textbox' type='text' name='primary_language' id='primary_language' size='30' value= '$primary_language' /></td>
			  </tr>
			  	  <tr>     
				  <td><label  class='field' for='secondary_language'>Secondary Language</label></td>
				  <td > <input class='textbox' type='text' name='secondary_language' id='secondary_language' size='30' value='$secondary_language' /></td>
			  </tr>
			  <tr>     
				  <td><label  class='field' for='trans_language'>Translation language()</label></td>
				  <td > <input class='textbox' type='text' name='trans_language' id='t_language' size='30' value= '$trans_language' /></td>
			  </tr>
		    </tr>
		    <tr>     
		  		<td><label  class='field' for='comments'>Coupon</label></td>
	  			<td > <input class='textbox' type='text' name='t_coupon' id='t_coupon' size='15' value= '$t_coupon' /></td>
	  		</tr> 
	  	  	<tr>     
		  		<td><label  class='field' for='comments'>Comments</label></td>
		  		<td > <textarea class='textbox' name=comments cols='50'>
		  		" .$comments. "</textarea> </td>
	  		</tr>
			 ";
	  
	  if(!empty($zip_code) && ($zip_error == '1'))
		  {
			  $output .= "<tr> <td> <label> Zip code error </label></td>
						  <td><p class='required' align='center'> ";
			  $output .= "Zip code is not in correct format or is missing";
			  $output .= "</p> </td> </tr>";
		  }               
					  
		//  former email output
		  //$output .= "            
			
			//	  ";
	  if(!empty($email_address) && ($email_error == '1'))
		  {
			  $output .= "<tr> <td> <label> email address error</label></td>
						  <td><p class='required' align='center'> ";
			  $output .= $error_invalid_email;
			  $output .= "</p> </td> ";
		  }                
	   $output .= "
				  
		</table>
			<p class='required' align='center'>* Required field.</p>
			<p align='center'><input class='btn' type='submit' name='action' value='Add this Person to Registration' />  </p>
	  </form>
	  <p align='center'>Or </p>
	  
	  <p class='nav' align='center'><a href='clearCart.php?clear=1'>Cancel and Clear Cart</a><br /></p>
			  
		  </div>
		 <br />
	  ";
	  echo $output;
        }
        else
        {  //if form is complete, all required fields done and correct, then add the item or items to shopping cart
		
		// first log info about who is being registered also used by exhibitor registration for person attending
		  $reg_date =  date('m-d-y - H:m:s');
		   $myFile=LOG_FILE."/registration.log";
		  $fh = fopen($myFile, 'a') or die("can't open file");
        print_r(error_get_last());
		  
		  $v = "["  . $reg_date  . "],  " 
		  . $_REQUEST['agency_name'] . ",  " 
		  . $_REQUEST['ag_address1'] . ",  " 
		  . $_REQUEST['ag_address2'] . " , " 
		  . $_REQUEST['ag_city'] . " , " 
		  . $_REQUEST['ag_state'] . " , " 
		  . $_REQUEST['ag_zip'] . " , " 
		  . $_REQUEST['ag_night_phone_a'] . "-" . $_REQUEST['ag_night_phone_b'] . "-" . $_REQUEST['ag_night_phone_c'] . " , " 
		  . $_REQUEST['ag_email'] . " , " 
		  . $_REQUEST['first_name'] . ",  "
		  . $_REQUEST['last_name'] . " , "
		  . $_REQUEST['adultchild'] . " , " 
		  . $_REQUEST['email'] . " , " 
		  . $_REQUEST['recordings'] ."\n"; 
		  
		  
		  fwrite($fh, $v);
		  fclose($fh);
        
 		  $coupon_row=valid_coupon($t_coupon); //db call 
		    
         // $code_val= $coupon_row[1]['code'];;//TBD to get the coupon codes entered
      
	     $coupon_value =$coupon_row[1]['value'];
		 
		 if ( $coupon_value >0) { //it is a valid coupon get the value
		    $shopping_cart->AddCoupon($coupon_value); //sum that up in session
		    $shopping_cart->AddCouponCode($t_coupon); //sum that up in session
		    set_shopping_cart($shopping_cart);  
		  }
		
        if ($adult_child === 'ADULT')
            {
                $product_id =    'ADULT';
                $shopping_cart->AddItem($product_id);
                set_shopping_cart($shopping_cart);  
            }
        if ($adult_child === 'CHILD')
            {
                $product_id = 'CHILD';
                $shopping_cart->AddItem($product_id);
                set_shopping_cart($shopping_cart);  
            }
      /*  if ($recordings === 'RECORDINGS')
            {
                $product_id = 'RECORDINGS';
                $shopping_cart->AddItem($product_id);
                set_shopping_cart($shopping_cart);  
            }*/ 
            //since we yanked the code from engage we are using recording logic of ethno training
            
		    if ($recordings === 'RECORDINGS')
            {
                $product_id = 'ETRAIN';
                $shopping_cart->AddItem($product_id);
                set_shopping_cart($shopping_cart);  
            }
		
        echo render_shopping_cart_coupon($shopping_cart);  
        echo "<div class='nav' align='center'>
            <a href='placeOrder.php'>Go to Checkout</a> 
                <p align='center'> Or </p>
            <a href='clearCart.php?clear=1'>Cancel and Clear Cart</a>
            </div>  
    <div>"; 
			// this lets is for registering another person on the same order
            echo " 
			<div class='section'> 
                    <form method='post' action='processGroup.php' id='add_names'>
					<h2 align='center'> Or add  another person to register </h2>
                        <table cellpadding='4' align='center'>
                </tr>  ";  
    
			  render_basic_form();
	  } //end ELSE
}
if (($_SERVER['REQUEST_METHOD'] == 'POST') && (!empty($_POST['exhb_complete'])) ) {
	// this is when it comes in from an exhibitor registration and needs to add names. 
      echo "    
    <div>
            <div class='section'>
                    <form method='post' action='processGroup.php' id='add_names'>
                    <h2 align='center'> Please fill in information of person registering </h2>
                        <table cellpadding='4' align='center'>
                </tr>  ";   
     
     render_basic_form();
}
    


 // This is for special registration case 
 if (($_SERVER['REQUEST_METHOD'] == 'GET') && ($_GET['id'] == 'HOST' )) {
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

