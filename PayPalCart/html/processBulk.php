<?php
ob_start(); 
require_once '../functions/PP_functions.php';

$shopping_cart = get_shopping_cart();
   
echo  render_header(); 

?>

<?php

//first time start of registration start here, to fill in basic form
 
if (($_SERVER['REQUEST_METHOD'] == 'GET') && (empty($_GET['id'])))  {
		$username = 'registration';
		$hostname = 'ispectraignite.org';
		$linktext = $username + '@' + $hostname ;
										
   echo "    
    <div>
            <div class='section'>
                    <form method='post' action='processBulk.php' id='add_names'>
                    <h3 align='center'>Please fill information of person registering, avoid Browser Back button.</h3>
                    <h3 align='center'> Use clear cart to change.  Help email
                                        <a href='mailto:registration@ispectraignite.org'>registration@ispectraignite.org</a> 					</h3>
                    
                        <table cellpadding='4' align='center'>
                </tr>  ";   
     
     render_bulk_form();  
}  

    
if (($_SERVER['REQUEST_METHOD'] == 'POST') && (!empty($_POST['action'])))
{	// check to see if form is complete, repeat until all required items are complete and correct
    $checked = "checked";
    $email_error = (!preg_match('/\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b/i', $_POST['email']))  ;
    $error_invalid_email = "You have entered and invalid Email address";
    
    $first_name = !empty($_POST['first_name']) ? $_POST['first_name'] : "";  
    $last_name = !empty($_POST['last_name']) ? $_POST['last_name'] : ""; 
    $email_address= !empty($_POST['email']) ? $_POST['email'] : ""; 
    $adult_child = !empty($_POST['adultchild']) ? $_POST['adultchild'] : "";
    $adult = !empty($_POST['adult']) ? $_POST['adult'] : "";
    $church = !empty($_POST['church']) ? $_POST['church'] : "";
	$count= !empty($_POST['count']) ? $_POST['count'] : "";
	$comments= !empty($_POST['comments']) ? $_POST['comments'] : "";
	
	
	    ///tbd block using coupon for peoples infor 
	  
	   
	    /*if(!empty($zip_code) && ($zip_error == '1'))
		  {
			  $output .= "<tr> <td> <label> </label></td>
						  <td><p class='required' align='center'> ";
			  $output .= "Zip code is not in correct format or is missing";
			  $output .= "</p> </td> </tr>";
		  }  */             
					  
	       $output ="";
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
 		if(empty($_POST['church']))
		  {
			  $output .= "<tr> <td> <label> </label></td>
						  <td><p class='required' align='center'> ";
			  $output .= "Provide Church, Org. Name  ";
			  $output .= "</p> </td> ";
		  }
		  		  
 	   
   	if(empty($_POST['count']) || ( $count < 10))
		{
	
	
			  $output .= "<tr> <td> <label> </label></td>
						  <td><p class='required' align='center'> ";
			  $output .= "Group registeration can't be less than 10 people!!! ";
			  $output .= "</p> </td> ";
			
		}
	
 	

	//check to see if all required items in form are complete and correct.       
    if (empty($_POST['first_name']) || 
        empty($_POST['last_name']) ||
      //  empty($_POST['contact_number'])||
        empty($_POST['adultchild']) ||
        empty($_POST['email']) ||
         (empty($_POST['count']) || ( $count < 10)) ||
        (!empty($_POST['email']) && ($email_error == '1')))
       {
      
	 	 $output .= "<p align='center' class='required'>____</p>";  
	
	
	  $output .= "<div class='form'>
			  <form method='post' action='processBulk.php' id='peoples_names'>";
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
	           <td><label for='recordings'><a href='http://www.ispectraignite.org/'>  iSpectra Conference April 24-26, $89&nbsp;</a>
			      		<input class='' type='hidden' name='adult' id='adult' size='25' value='groupadult' "; 
			   			//if (!empty($adult)) {$output .=  $checked;}
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
				  <td><label  class='required' for='church'>* Church,Org. Name</label></td>
				  <td ><input class='textbox' type='text' name='church' id='church' size='50' value= '$church' /></td>
			  	  <td></td>
			</tr> 
			 				  
	
			 <tr>
			  <td><label class='required' for='last_name'>* Count(10 or more)</label></td>
			  <td><input class='textbox' type='text' name='count' id='count' size='30' 
			  	value= '$count'/></td>
		     <td></td>
     		</tr>		  	 <tr>     
		  		<td><label  class='field' for='comments'>Comments</label></td>
		  		<td > <textarea class='textbox' name=comments cols='50'>
		  		" .$comments. "</textarea> </td>
	  		  	<td></td>
			</tr>
			 ";
	  
	                 
	   $output .= "
				  
		</table>
			<p class='required' align='center'>* Required field.</p>
			<p align='center'><input class='btn large blue' type='submit' name='action' value='Submit Registration' />  </p>
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
		 //for loop
		
 		if ($adult === 'groupadult'){
	        if ($adult_child === 'ADULT')
	            {
	               for ($i = 1; $i <= $count; $i++) {
		 
					$product_id =    'GROUPADULT';
	                $shopping_cart->AddItem($product_id);
	                set_shopping_cart($shopping_cart); 
	                } 
	            }
	      
		}
      /*  if ($recordings === 'RECORDINGS')
            {
                $product_id = 'RECORDINGS';
                $shopping_cart->AddItem($product_id);
                set_shopping_cart($shopping_cart);  
            }*/ 
            //since we yanked the code from engage we are using recording logic of ethno training
            
		 
		    $myFile=LOG_FILE."/bulkregistration.log";
		  $fh = fopen($myFile, 'a') or die("can't open file");
        print_r(error_get_last());
		  
	  $v= $_REQUEST['first_name']."~" 
		  .$_REQUEST['last_name']."~" 
		  .$_REQUEST['email']."~"
		  .$_REQUEST['church']."~" 
		  .$_REQUEST['count']."~" 
		  .$_REQUEST['comments']."~" 
		  .$shopping_cart->GetGcode()."\n"; 
		  
    $sql ="INSERT INTO `register`( `first_name`,
                       `last_name`, 
                       `email`, 
                       `church`, 
                       `count`, 
                       `comments` ,
                       `gcode`) VALUES ($id)";
	   
		  fwrite($fh, $v);
		  fclose($fh);
        
 		 insert_gregister($v); //db insert
		
        echo render_shopping_cart_coupon($shopping_cart);  
		$time = time();
        echo "<div class='nav' align='center'>
        <BR>
            <a class='btn large blue' href='placeOrder.php?nocache=".$time ."'>Go to Checkout</a> 
                <p align='center'> Or </p>
            <a href='clearCart.php?clear=1'>Cancel and Clear Cart</a>
            </div>  
    <div>"; 
			// this lets is for registering another person on the same order
           
			//  render_bulk_form();
	  } //end ELSE
}
if (($_SERVER['REQUEST_METHOD'] == 'POST') && (!empty($_POST['exhb_complete'])) ) {
	// this is when it comes in from an exhibitor registration and needs to add names. 
   
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
ob_end_flush();
?>

