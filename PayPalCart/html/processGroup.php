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
    $country = !empty($_POST['country']) ? $_POST['country'] : "";   
    $zip_code = !empty($_POST['zip']) ? $_POST['zip'] : "";    
    $email_address = !empty($_POST['email']) ? $_POST['email'] : "";
    $adult_child = !empty($_POST['adultchild']) ? $_POST['adultchild'] : "";
    $recordings = !empty($_POST['recordings']) ? $_POST['recordings'] : "";
    $adult = !empty($_POST['adult']) ? $_POST['adult'] : "";
    $church = !empty($_POST['church']) ? $_POST['church'] : "";
	$t_coupon= !empty($_POST['t_coupon']) ? $_POST['t_coupon'] : "";
	$ethinicity= !empty($_POST['ethinicity']) ? $_POST['ethinicity'] : "";
	$primary_language= !empty($_POST['primary_language']) ? $_POST['primary_language'] : "";
	$secondary_language= !empty($_POST['secondary_language']) ? $_POST['secondary_language'] : "";
	$trans_language= !empty($_POST['trans_language']) ? $_POST['trans_language'] : "";
	$comments= !empty($_POST['comments']) ? $_POST['comments'] : "";
	$zip_error = (!preg_match('/^\d{5}(?:-\d{4})?$/', $zip_code));//tbd
	
	
	    ///tbd block using coupon for peoples infor 
	      $coupon_error=-1;
	
	     if(empty($adult) && ($t_coupon!='STANDARD'))
		  {
			  $output .= "<tr> <td> <label> </label></td>
						  <td><p class='required' align='center'> ";
			  $output .= "Program code is not applicable to people group workshop use STANDARD or select iSpectra";
			  $output .= "</p> </td> </tr>";
			  $coupon_error=1;
		  }
		
	   
	    /*if(!empty($zip_code) && ($zip_error == '1'))
		  {
			  $output .= "<tr> <td> <label> </label></td>
						  <td><p class='required' align='center'> ";
			  $output .= "Zip code is not in correct format or is missing";
			  $output .= "</p> </td> </tr>";
		  }  */             
					  
	
	     if(!empty($email_address) && ($email_error == '1'))
		  {
			  $output .= "<tr> <td> <label> </label></td>
						  <td><p class='required' align='center'> ";
			  $output .= $error_invalid_email;
			  $output .= "</p> </td> ";
		  }
 		if(empty($_POST['first_name']))
		  {
			  $output .= "<tr> <td> <label> </label></td>
						  <td><p class='required' align='center'> ";
			  $output .= "Enter your first name";
			  $output .= "</p> </td> ";
		  }
 		if(empty($_POST['last_name']))
		  {
			  $output .= "<tr> <td> <label> </label></td>
						  <td><p class='required' align='center'> ";
			  $output .= "Enter your last name";
			  $output .= "</p> </td> ";
		  }
 		if(empty($_POST['email']))
		  {
			  $output .= "<tr> <td> <label> </label></td>
						  <td><p class='required' align='center'> ";
			  $output .= "Enter your email ";
			  $output .= "</p> </td> ";
		  }
 		if(empty($_POST['adult']) && empty($_POST['recordings']))
		  {
			  $output .= "<tr> <td> <label> </label></td>
						  <td><p class='required' align='center'> ";
			  $output .= "Select iSpectra  or Peoples Group ";
			  $output .= "</p> </td> ";
		  }
		  		  
		  
	    $coupon_row=-1;
	    if (!empty($_POST['t_coupon']))
		{
			$coupon_row  = valid_coupon($t_coupon);
		}
		if ($coupon_row!=-1)
		{
			$coupon_value =$coupon_row[1]['value'];
		}
		else
		{
			$coupon_value=-1;
			
		}

   	if(!empty($_POST['t_coupon']) && ( $coupon_value < 0))
		{
			  $output .= "<tr> <td> <label> </label></td>
						  <td><p class='required' align='center'> ";
			  $output .= "Validate your program code ";
			  $output .= "</p> </td> ";
			
		}
	
   	$coutput = countryArray("country", "US");
	

	//check to see if all required items in form are complete and correct.       
    if (empty($_POST['first_name']) || 
        empty($_POST['last_name']) ||
      //  empty($_POST['contact_number'])||
        empty($_POST['adultchild']) ||
        empty($_POST['email']) ||
        (empty($_POST['adult']) && empty($_POST['recordings'])) ||
        ($coupon_error == '1') ||
        (!empty($_POST['t_coupon']) && ( $coupon_value < 0)) ||
        (!empty($_POST['email']) && ($email_error == '1')))
       {
      
	 	 $output .= "<p align='center' class='required'>____</p>";  
	
	
	  $output .= "<div class='form'>
			  <form method='post' action='processGroup.php' id='peoples_names'>";
			  if ($shopping_cart->GetTotal()>0)
			  {
			    echo render_shopping_cart($shopping_cart);
			  }
		 $output .= "
		 	  <table cellpadding='4'>
			   <tr>
			   
		  	   <td colspan=3>
			     <center>  
			     <table >
			   <tr>     
	           <td><label for='recordings'><a href='http://www.ispectraignite.org/'>  iSpectra Conference April 24-26, $99&nbsp;</a>
			      		<input class='' type='checkbox' name='adult' id='adult' size='25' value='adult' "; 
			   			if (!empty($adult)) {$output .=  $checked;}
			  			$output .=  "
			  	  		/>
			  	    </label>
		         </td>
	             <td><label  for='recordings'><a href='http://www.peoplegroups.info/'> &nbsp; PeopleGroups.info  Workshop April 22-23, $35&nbsp;</a>	
				  		 <input  type='checkbox' name='recordings' id='recordings' size='25' value= 'ETRAIN' "; 
			   			 if (!empty($recordings)) {$output .=  $checked;}
			  			 $output .=  "
			  			 />
			  			</label>
			  	  </td> 
			   </tr>
			   </table>
			   </center>
			   </td>
		 
			
	  		</tr>
			 <tr>
			 
			  <td><label class='required' for='first_name'>* First Name</label></td>
			  <td ><input class='textbox' type='text' name='first_name' id='first_name' size='30' 
			  	value= '$first_name' /></td>
			  <td></td>
			 </tr>
			 <tr>
			  <td><label class='required' for='last_name'>* Last Name</label></td>
			  <td><input class='textbox' type='text' name='last_name' id='last_name' size='30' 
			  	value= '$last_name'/></td>
		     <td></td>
     		</tr>			
		   <tr>
				  <td ><label class='required'  class='field' for='email'>* Email Address</label></td>
				  <td><input class='textbox' type='text' name='email' id='email' size='40' value= '$email_address'/>
				  </td>
				  <td>				  	   <input type='hidden' name='adultchild' id='adultchild' value= 'ADULT' />
				  </td>
			  </tr>
		  
	   		<tr>
			   <tr>
				  <td><label class='field' for='address'> Address Line 1</label></td>
				  <td ><input class='textbox' type='text' name='address1' id='address1' size='40' 
				  	value= '$address_first' /></td>
				  <td></td>
			  </tr>
			  <tr>
				  <td><label class='field' for='address'>Address Line 2</label></td>
				  <td ><input class='textbox' type='text' name='address2' id='address2' size='40' 
				  	value= '$address_second' /></td>
				  <td></td>
			  </tr>
			  <tr>
				  <td><label class='field' for='city'> City</label></td>
				  <td ><input class='textbox' type='text' name='city' id='city' size='40' value= '$city_name' /></td>
				  <td></td>
			  </tr>
			  
			  <tr>
				  <td><label class='field' for='state'> State</label></td>
				  <td >
					  <input class='textbox' type='text' name='state' id='state' size='2' value= '$state_name' />
					  <label class='field' for='zip'>&nbsp;&nbsp;<strong> Zip</strong>&nbsp;</label>
					  <input class='textbox' type='text' name='zip' id='zip' size='10' value= '$zip_code' />
				  </td>
				  <td></td>
			  </tr> 
			  <tr>
				  <td>
				  <label class='field' for='Country'> Country</label></td>
				  <td align='left' class='field' >$coutput		  
				  </td>
			  	  <td></td>
			</tr>	  
			  <tr>
				  <td><label class='field' for='church'>Church,Org. Name</label></td>
				  <td ><input class='textbox' type='text' name='church' id='church' size='50' value= '' /></td>
			  	  <td></td>
			</tr> 
			<tr>     
			  <td><label  class='field' for='contact_number'>Phone</label></td>
			  <td > <input class='textbox' type='text' name='contact_number' id='contact_number' size='30' 
			  value= '$contact_number' />
			   </td>
			  <td></td>
			 </tr>

				  
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
			      
				  <td>
				  <label  class='field' for='ethinicity'>Ethinicity</label></td>
				  <td > <input class='textbox' type='text' name='ethinicity' id='ethinicity' size='30' value= '$ethinicity' /></td>
				  <td></td>
			  </tr>
			  <tr>     
				  <td><label   class='field' for='primary_language'>Primary Lang.</label></td>
				  <td > <input class='textbox' type='text' name='primary_language' id='primary_language' size='30' value= '$primary_language' /></td>
				  <td></td>
			  </tr>
			  	  <tr>     
				  <td><label  class='field' for='secondary_language'>Secondary Lang.</label></td>
				  <td > <input class='textbox' type='text' name='secondary_language' id='secondary_language' size='30' value='$secondary_language' /></td>
				  <td></td>
			  </tr>
			  <tr>     
				  <td><label  class='field' for='trans_language'>Translation Lang.</label></td>
				  <td > <input class='textbox' type='text' name='trans_language' id='t_language' size='30' value= '$trans_language' /></td>
				  <td></td>
			  </tr>
		    </tr>
		    <tr>";
			if ($coupon_value > 0 ) {
				$output .="<td><label   class='field' for='Coupon'>Program Code</label></td>";
			}else{
				$output .="<td><label   class='required' for='Coupon'>Program Code</label></td>";
			}
				
	  		$output .="	<td > <input class='textbox' type='text' name='t_coupon' id='t_coupon' size='15' value= 
	  		'$t_coupon' /></td>
	  			<td></td>
			 </tr> 
	  	  	 <tr>     
		  		<td><label  class='field' for='comments'>Comments</label></td>
		  		<td > <textarea class='textbox' name=comments cols='50'>
		  		" .$comments. "</textarea> </td>
	  		  	<td></td>
			</tr>
			 ";
	  
	                 
	   $output .= "
				  
		</table>
			<p class='required' align='center'>* Required field.</p>
			<p align='center'><input class='btn large blue' type='submit' name='action' value='Add this Person to Registration' />  </p>
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
		 
		 if ( $coupon_value >0) { //it is a valid coupon get the value
		    $shopping_cart->AddCoupon($coupon_value); //sum that up in session
		    $shopping_cart->AddCouponCode($t_coupon); //sum that up in session
		    set_shopping_cart($shopping_cart);  
		  }
 		if ($adult === 'adult'){
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
		}
      /*  if ($recordings === 'RECORDINGS')
            {
                $product_id = 'RECORDINGS';
                $shopping_cart->AddItem($product_id);
                set_shopping_cart($shopping_cart);  
            }*/ 
            //since we yanked the code from engage we are using recording logic of ethno training
            
		    if ($recordings === 'ETRAIN')
            {
                $product_id = 'ETRAIN';
                $shopping_cart->AddItem($product_id);
                set_shopping_cart($shopping_cart);  
            }
		    $myFile=LOG_FILE."/registration.log";
		  $fh = fopen($myFile, 'a') or die("can't open file");
        print_r(error_get_last());
		  
	  $v= $_REQUEST['first_name']."~" 
		  .$_REQUEST['last_name']."~" 
		  .$_REQUEST['contact_number']."~" 
		  .$_REQUEST['address1']."~" 
		  .$_REQUEST['address2']."~" 
		  .$_REQUEST['city']."~" 
		  .$_REQUEST['state']."~" 
		  .$_REQUEST['zip']."~" 
		  .$_REQUEST['country']."~" 
		  .$_REQUEST['email']."~"
		  .$recordings."~" 
		  .strtoupper($adult)."~" 
		  .$_REQUEST['church']."~" 
		  .$_REQUEST['t_coupon']."~" 
		  .$_REQUEST['ethinicity']."~" 
		  .$_REQUEST['primary_language']."~" 
		  .$_REQUEST['secondary_language']."~ " 
		  .$_REQUEST['trans_language']."~" 
		  .$_REQUEST['comments']."~" 
		  .$shopping_cart->GetGcode()."\n"; 
		  
      
		  fwrite($fh, $v);
		  fclose($fh);
        
 		 insert_register($v); //db insert
		
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
echo render_footer();

?>

