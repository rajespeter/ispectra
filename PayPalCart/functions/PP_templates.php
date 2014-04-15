<?php
function render_header($title = 'iSpectra Conference Registration') {
    $header = file_get_contents('../../includes/header.php');
    echo $header;
/*
return '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <title>'.$title.'</title>
        
        <link href="../../css/main.css" rel="stylesheet" type="text/css" />
        
    </head>

    <body>   

<div id="outerDiv">

    <div id="header">
       <!-- <div id="contactButton">
            <a href="../../contact.php" title="contact us"  target="_blank" > </a>
        </div>
        
        <div id="homeButton">
            <a href="../../index.php" title="The Harvest Group Home page"> </a>
        </div> -->
        
    </div> <!-- header -->

    <!--div id="midBanner">
        <img src="../../images/Engage-logo_with_tag_line.png" width="960" height="150" alt="Welcome to Engage for God" />
    </div-->
            
    <div class="wrapper">
            
';  */      
} 

function render_footer() {
    echo '<p align="center"> 
             <a href="../../registration.php" title="iSpectra Registration"> Return to Registration </a>
             </p>
             <p>&nbsp;</p>';
    $footer = file_get_contents('../../includes/footer.php');
    echo $footer;

    /*
     return '
         

     <div id="footer">
         <p  align="center"> 
             <a href="../../registration.php" title="iSpectra Home page"> Return to Registration Home page </a>
             </p>
        <p >&copy; iSpectra &nbsp;&nbsp; 
        <a href="../../privacy.htm" target="_blank" >Privacy Policy</a> | 
        <a href="../../terms.htm" target="_blank" >Terms and Conditions</a> | 
        <a href="../../contact.php" title="contact us"  target="_blank" > Contact Us </a>
        </p>
</div>
    </div>
    
 </div> <!-- outerDiv -->

 </body>

</html>';  */
 }  


   
function render_products_from_xml() {

    $output = '<br />
                <table class="products">
                <tr>';
    
    foreach(get_xml_catalog() as $product) {
        $output .= '
                 
                    <td class="product">
                        <h2>' . $product->title . '</h2>
                        <div>
                            <img src=" '.$product->img.'" height="50" width="75" />
                            <span>
                                '.$product->description.'
                            </span>
                        </div>
                        <div class="price">
                            $'.$product->price.'
                        </div>
                        <div class="addToCart">
                            <a href="addToCart.php?id='.$product->id.'">add to cart</a>
                        </div>
                      </td>
                    ';
    }
        $output .= ' </tr>
        </table>
        ';
    return $output;
}  

function render_products()
{
    $products = get_products();
    
    if ($products == FALSE)
    {
        $output = "<table class='products'><tr>";
        $output .= "<td>No products to display!</td>";
        $output .= "</tr></table>";
    }
    else
    {
        $output = "<table class='products'><tr>";
    
        foreach ($products as $product)
        {
            $output .= "
                <td>
                <div class='product'>
                    <h2>".$product['title']."</h2>
                    <div>
                        <img src='".$product['image']."' width='100' height='80' />
                        ".$product['description']."
                    </div>
                    <div class='price'>
                        $".$product['price']."
                    </div>
                    <div class='addToCart'>
                        <a href='addToCart.php?id=".$product['id']."'>add to cart</a>
                    </div>
                </div>
                </td>
            ";
        }
        $output .= "</tr></table>";
        return $output;
    }
}


// Shopping cart templates

function render_shopping_cart_row(ShoppingCart $shopping_cart , $product_id , $line_item_counter) 
{
           
       $quantity = $shopping_cart->GetItemQuantity($product_id);  
       
       $amount = $shopping_cart->GetItemCost($product_id); 
       
       $unit_cost = get_item_cost($product_id);
       
       $shipping_amount = 0.00;
       $prodname=($product_id!="ETRAIN")?$product_id:"Ethnographic Training";
       
       $output = " 
        <tr>
            <td>
                $prodname
                <input type='hidden' name='item_name_$line_item_counter' value='$product_id' />
            </td>
            <td>
                $quantity
                <input type='hidden' name='quantity_$line_item_counter' value='$quantity' />
            </td>
            <td>
                $ $unit_cost
            </td>                
            <td>
                $ $amount
                 <input type='hidden' name='amount_$line_item_counter' value='$unit_cost' />
                 <input type='hidden' name='shipping_$line_item_counter' value='$shipping_amount' />
                 
            </td>        
        </tr>    
        ";
        return $output;
}

function render_shopping_cart_shipping_row(ShoppingCart $shopping_cart)
{
    return "
    <tr>
            <td>
                
            </td>
            <td>
                
            </td>
            <td>
              Shipping  
            </td>
                                        
            <td>
            $ ".$shopping_cart->GetShippingCost()."
             </td>         
        </tr>    
        ";   
}

function render_shopping_cart_total_row(ShoppingCart $shopping_cart)
{
    $total=$shopping_cart->GetTotal();
   // $finaltotal=$total-$coupon_value;
    return "
    <tr>
            <td>
                
            </td>
            <td>
                
            </td>
            <td>
              Total  
            </td> 
            
            <td>
            $ ".$total."
             </td>        
        </tr>    
        ";   
}

function render_shopping_cart(ShoppingCart $shopping_cart) 
{    
    $output="
    <table class='shoppingCart' >
    <tr>
        <th>
            Product ID 
        </th>
        <th>
            Quantity
        </th>
        <th>
            Unit Cost
        </th>  
        <th>
            Sub Total
        </th>   
    </tr>";

    $line_item_counter = 1;
    
    foreach ($shopping_cart->GetItems() as $product_id) 
    {
        $output .= render_shopping_cart_row($shopping_cart, $product_id, $line_item_counter);
        $line_item_counter++; 
    }
     //$output .= render_shopping_cart_shipping_row($shopping_cart); 
      
      $output .= render_shopping_cart_total_row($shopping_cart) ;
       
  //  $output .= render_shopping_cart_total_row($shopping_cart);
    $output .= "
          </table>
          ";

    return $output;
}
function render_shopping_cart_coupon(ShoppingCart $shopping_cart)//,$final removed var for total coupon 
{
    $coupon_value = $shopping_cart->GetCoupon();//session call for total sum of coupon
    $coupon_codes = $shopping_cart->GetCouponCode();//session call for all the codes applies
    $code_array = implode("','", $coupon_codes)  ;  
    $formcpn = -1;
    
if ($formcpn==1) {
     $output="
    <form action='placeOrder.php' method='post' id='shoppingcart' >
       <input type='hidden' name='cform' value='cform' />";
       }
  $output="
    <table class='shoppingCart' >
    <tr>
        <th>
            Product ID 
        </th>
        <th>
            Quantity
        </th>
        <th>
            Unit Cost
        </th>  
        <th>
            Sub Total
        </th>   
    </tr>";

    $line_item_counter = 1;
    
    foreach ($shopping_cart->GetItems() as $product_id) 
    {
        $output .= render_shopping_cart_row($shopping_cart, $product_id, $line_item_counter);
        $line_item_counter++; 
    }
     if ($coupon_value>0) { //if not -1
         
            
       $output .= "
        
          <tr>
              <td colspan=2><label class='field' for='first'> Program Code Applied</label></td>
              <td ><label class='field' for='first'>    '".$code_array ."' </label></td>
              <td>
                   $ ".$coupon_value."  
              </td>
          </tr>
          ";
        }
      $output .= render_shopping_cart_total_row($shopping_cart);
       

if ($formcpn==1) {
   $output .= "
        
          <!--tr>
              <td colspan=2><label class='field' for='first'>Enter Coupon Code</label></td>
              <td ><input class='textcpn' type='text' name='coupon' id='coupon'  size=10 value= '' /></td>
              <td>
              <input class='btn large smoke' type='submit' name='submit' value='Apply  Coupon'/> 
              </td>
          </tr-->
          
          </table>
          </form>";
}else{
        
             $output .= "
                  </table>
                  ";    
    
    
            
}
    return $output;
}

function render_paypal_checkout(ShoppingCart $shopping_cart)
{
    $first_name = !empty($_POST['first']) ? $_POST['first'] : "";  
    $last_name = !empty($_POST['last']) ? $_POST['last'] : "";  
    $address_first = !empty($_POST['address1']) ? $_POST['address1'] : "";  
    $address_second = !empty($_POST['address2']) ? $_POST['address2'] : "";  
    
    $city_name = $_POST['city'];   
    $state_name = $_POST['state'];   
    $zip_code = $_POST['zip'];   
    $phone_area_code = $_POST['night_phone_a'];   
    $phone_prefix = $_POST['night_phone_b'];
    $phone_postfix = $_POST['night_phone_c'];     
    $email_address = $_POST['email'];
         
    $coupon_value = $shopping_cart->GetCoupon();//session call
    $quantity_adults = $shopping_cart->GetItemQuantity($product_id = "ADULT") ;
     $gcode = $shopping_cart->GetGcode() ;
    
     if($quantity_adults >= 5) {
     	
        $discount_group = ($quantity_adults*10.00)+$coupon_value; 
		$discount_group=($discount_group > 0 )   ? $discount_group : 0;
         echo "You have registered 5 or more Adults, the discout will be aplied when you go to pay";
     } else{
       
       $discount_group = ($coupon_value > 0 )   ? $coupon_value : 0;
        
     }
     
     //echo "ADULTS = " . $quantity_adults; 
    // echo "<br /> discount = " .$discount_group;
   
    echo "<div class='payment-person'>" ;
    echo $first_name . " " . $last_name ."<br />";
    echo $address_first ."<br />";
    if ($address_second != "") {echo $address_second ."<br />"; }  
    echo $city_name . ", " . $state_name . "  " . $zip_code  ."<br />";
    echo $phone_area_code . "-" . $phone_prefix . "-" . $phone_postfix  ."<br />";
    echo $email_address ."<br />";
    
    
          
   echo "</div>"; 
        
    return  "
           
    <form action=' ".PAYPAL_FORM_URL. " ' method='post' >
        <input type='hidden' name='business' value=' " .PAYPAL_BUSINESS_VALUE. "  ' />
        <input type='hidden' name='cmd' value='_cart' />
        
        <input type='hidden' name='upload' value='1' />
        <input type='hidden' name='currency_code' value='USD' />
        <input type='hidden' name='lc' value='US' />
        <input type='hidden' name='discount_amount_cart' value='$discount_group' />

        " .render_shopping_cart_coupon($shopping_cart,0).  "
        <br />
        
        <input type='hidden' name='first_name' value='$first_name'>
        <input type='hidden' name='last_name' value='$last_name'>
        <input type='hidden' name='address1' value='$address_first'>
        <input type='hidden' name='address2' value='$address_second'>
        <input type='hidden' name='city' value='$city_name'>
        <input type='hidden' name='state' value='$state_name'>
        <input type='hidden' name='zip' value='$zip_code'>
        <input type='hidden' name='night_phone_a' value='$phone_area_code'>
        <input type='hidden' name='night_phone_b' value='$phone_prefix'>
        <input type='hidden' name='night_phone_c' value='$phone_postfix'>
        <input type='hidden' name='email' value='$email_address'>
         <input type='hidden' name='custom' value='$gcode'>
        
        <input type='hidden' name='notify_url' value=' " .PAYPAL_IPN_RETURN_URL. "  '>
        <input type='hidden' name='return' value=' " .PAYPAL_CHECKOUT_COMPLETE_URL. " '>
        <input type='hidden' name='rm' value='2'>
        <input type='hidden' name='page_style' value='Engage'>
        <input type='hidden' name='cbt' value='Return to The Store'>
        <input type='hidden' name='cancel_return' value='  " .PAYPAL_CANCEL_CHECKOUT_URL. "  '>

    <input type='image' src='https://www.paypal.com/en_US/i/btn/btn_paynowCC_LG.gif' border='0' name='submit' 
        alt='PayPal - The safer, easier way to pay online!'>
    <img alt='' border='0' src='https://www.paypal.com/en_US/i/scr/pixel.gif' width='1' height='1'>

</form>";
}


function render_agency_form()
{
    echo "
  <div>
    <div class='section'>
      <form method='post' action='exhibitors_reg.php' id='add_names'>
      <h4> Please Fill in information about your organization </h4>
      <table cellpadding='4' align='center'>
      <tr>
        <td><label class='required' for='agency'>* Your Agency or Organizations Name</label></td>
        <td ><input class='textbox' type='text' name='agency_name' id='agency_name' size='25' value= '$agency_name' /></td>
       </tr>
       <tr>
        <td><label class='required' for='address'>* Address Line 1</label></td>
        <td ><input class='textbox' type='text' name='ag_address1' id='ag_address1' size='40' value='$ag_address_first'/></td>
      </tr>
      <tr>
        <td><label class='field' for='address'>&nbsp;&nbsp;Address Line 2</label></td>
        <td ><input class='textbox' type='text' name='ag_address2' id='ag_address2' size='40' value='$ag_address_second'/></td>
      </tr>
      <tr>
        <td><label class='required' for='city'>* City</label></td>
        <td ><input class='textbox' type='text' name='ag_city' id='ag_city' size='40' value= '$ag_city_name'/></td>
      </tr>
      <tr>
        <td><label class='required' for='state'>* State</label></td>
        <td >
            <input class='textbox' type='text' name='ag_state' id='ag_state' size='2' value= '$ag_state_name' />
            <label class='required' for='zip'>&nbsp;&nbsp;<strong>* Zip</strong>&nbsp;</label>
            <input class='textbox' type='text' name='ag_zip' id='ag_zip' size='10' value= '$ag_zip_code' />
        </td>
      </tr>
      <tr>
        <td><label class='required' for='phone'>* Phone</label></td>
        <td >
        <input class='textbox' type='text' name='ag_night_phone_a' id='ag_night_phone_a' size='3' value='$ag_phone_area_code'/>
        <label class='field'>&nbsp;&nbsp;</label>
        <input class='textbox' type='text' name='ag_night_phone_b' id='ag_night_phone_b' size='3'value='$ag_phone_prefix'/>
        <label class='field'>&nbsp;&nbsp;</label>
        <input class='textbox' type='text' name='ag_night_phone_c' id='ag_night_phone_c' size='4' 
            value='$ag_phone_postfix'/></td>
      </tr>
      <tr>
          <td><label class='required' for='email'>* Email Address</label></td>
          <td ><input class='textbox' type='text' name='ag_email' id='ag_email' size='40' value= '$ag_email_address' /></td>
      </tr>                               
      <tr>                        
      </tr>
  </table>
      <p class='required' align='center'>* Required field.</p>
      <p align='center'><input class='btn large blue' type='submit' name='register' value='Register Your Agency' />  </p>       
      
      <p  align='center'>
      
      Or </p>
       <p class='nav' align='center'><a href='exh_clearCart.php?clear=1'>Cancel and Clear Cart</a>
      </p>    
    </form> 
            
                
    </div> 
    
  </div>
  
  ";
  }

function render_agency_form_completed()
{
    echo "
  <div>
      <div class='section'>
      <form method='post' action='processGroup.php' id='add_names'>
      <h4> Please Fill in information about your organization </h4>
      <table cellpadding='4' align='center'>
      <tr>
        <td><label class='required' for='agency'>* Your Agency or Organizations Name</label></td>
        <td ><input class='textbox' type='text' name='agency_name' id='agency_name' size='25' value='$agency_name'/></td>
      </tr>
      <tr>
        <td><label class='required' for='address'>* Address Line 1</label></td>
        <td ><input class='textbox' type='text' name='ag_address1' id='ag_address1' size='40' value='$ag_address_first'/></td>
      </tr>
      <tr>
        <td><label class='field' for='address'>&nbsp;&nbsp;Address Line 2</label></td>
        <td ><input class='textbox' type='text' name='ag_address2' id='ag_address2' size='40' value='$ag_address_second'/></td>
      </tr>
      <tr>
        <td><label class='required' for='city'>* City</label></td>
        <td ><input class='textbox' type='text' name='ag_city' id='ag_city' size='40' value= '$ag_city_name' /></td>
      </tr>
      <tr>
        <td><label class='required' for='state'>* State</label></td>
        <td >
            <input class='textbox' type='text' name='ag_state' id='ag_state' size='2' value= '$ag_state_name' />
            <label class='required' for='zip'>&nbsp;&nbsp;<strong>* Zip</strong>&nbsp;</label>
            <input class='textbox' type='text' name='ag_zip' id='ag_zip' size='10' value= '$ag_zip_code' />
        </td>
      </tr>
      <tr>
        <td><label class='required' for='phone'>* Phone</label></td>
        <td >
        <input class='textbox' type='text' name='ag_night_phone_a' id='ag_night_phone_a' size='3' value='$ag_phone_area_code'/>
        <label class='field'>&nbsp;&nbsp;</label>
        <input class='textbox' type='text' name='ag_night_phone_b' id='ag_night_phone_b' size='3' value='$ag_phone_prefix'/>
        <label class='field'>&nbsp;&nbsp;</label>
        <input class='textbox' type='text' name='ag_night_phone_c' id='ag_night_phone_c' size='4' value='$ag_phone_postfix'/>
        </td>
      </tr>
      <tr>
          <td><label class='required' for='email'>* Email Address</label></td>
          <td ><input class='textbox' type='text' name='ag_email' id='ag_email' size='40' value= '$ag_email_address' /></td>
      </tr>                               
      <tr>                        
      </tr>
    </table>
        <p class='required' align='center'>* Required field.</p>
        <p align='center'><input class='btn large blue' type='submit' name='action' value='Action' />     </p>           
    </form> 
        <p class='nav' align='center'>
            
            Or </p>
             <p align='center'><a href='exh_clearCart.php?clear=1'>Cancel and Clear Cart</a>
            </p>
            
        </div> 
      
  </div>
        
        ";
}


function render_basic_form ()
{
        
    //invoking country function //
    $coutput = countryArray("country", "country");
    
    echo " 
     <tr>     
         <td colspan=3>
          <center>
	          <table >
	          <tr>     
	           <td><label for='recordings'><a href='http://www.ispectraignite.org/'>  iSpectra Conference April 24-26&nbsp;</a>
	            <input type='checkbox' name='adult' id='adult'  value='adult' checked /> </label></td>
	          
	           <td><label  for='recordings'><a href='http://www.peoplegroups.info/'> &nbsp; PeopleGroups.info  Workshop April 22-23&nbsp;</a>	
	         	   <input  type='checkbox' name='recordings' id='recordings'  value= 'ETRAIN' />
	            	</label>
	            </td>
	           </tr>
	           </table>
	         </td>
	         </center>
	       </tr>
     <tr>
     <tr>
     	<td><label  for='first_name'>* First Name</label></td>
        <td ><input class='textbox' type='text' name='first_name' id='first_name' size='30' value= '' /></td>
       	<td></td>
    </tr>
     <tr>     
  	    <td><label class='field'  for='last_name'>* Last Name</label></td>
	    <td><input class='textbox' type='text' name='last_name' id='last_name' size='40' value= '' /></td>
     	<td></td>
      </tr>
       <tr>
          <td><label class='field' for='email'> * Email Address  </label></td>
          <td ><input class='textbox' type='text' name='email' id='email' size='40' value= '' /></td>
          <td></td>
       </tr> 
     	<td><label class='field' for='address'> Address Line 1</label></td>
      	<td ><input class='textbox' type='text' name='address1' id='address1' size='40' value= '' /></td>
      	<td></td>
     </tr>
      <tr>
          <td><label class='field' for='address'>Address Line 2</label></td>
          <td ><input class='textbox' type='text' name='address2' id='address2' size='40' value= '' /></td>
          <td></td>
      </tr>
      <tr>
          <td><label class='field' for='city'> City</label></td>
          <td ><input class='textbox' type='text' name='city' id='city' size='40' value= '' /></td>
          <td></td>
      </tr>
      <tr>
          <td><label class='field' for='state'> State</label></td>
          <td ><input class='textbox' type='text' name='state' id='state' size='2' value= '' /></td>
          <td></td>
      </tr>
	  
	  <tr>
	  	  <td><label class='field' for='zip'> Zip</label></td>
		  <td ><input class='textbox' type='text' name='zip' id='zip' size='10' value= '$zip_code' /></td>
		  <td></td>
	  </tr> 
	  
	  <tr>
	      <td><label class='field' for='Country'> Country</label></td>
	      <td >
	         $coutput
	          
	      </td>
    	  <td></td>
      </tr>
      <tr>     
       	<td><label  for='contact_number'>Phone</label></td>
        <td ><input class='textbox' type='text' name='contact_number' id='contact_number' size='30' value= '' /></td>
      </tr>
     <tr>

       <input type='hidden' name='adultchild' id='adultchild' value= 'ADULT' />
					     <!--tr> 
					         <td><label  for='Adult or Child'>*  Adult or Child (Grades 1-6) </label></td>
					         <td >Adult<input class='radio' type='radio' name='adultchild' id='adultchild' value= 'ADULT' />
					              &nbsp;&nbsp;&nbsp;
					          Child<input class='radio' type='radio' name='adultchild' id='adultchild' value= 'CHILD' /></td>                          
					      </tr-->
        <tr>
          <td><label class='field' for='church'>Church/Organization</label></td>
          <td ><input class='textbox' type='text' name='church' id='church' size='50' value= '' /></td>
          <td></td>
        </tr> 
      
     
          <td><label  for='ethinicity'>Ethnicity</label></td>
          <td > <input class='textbox' type='text' name='ethinicity' id='ethinicity' size='30' value= '' /></td>
          <td></td>
      </tr>
      <tr>     
          <td><label  for='primary_language'>Primary Language</label></td>
          <td > <input class='textbox' type='text' name='primary_language' id='primary_language' size='30' value= '' /></td>
          <td></td>
      </tr>
      <tr>     
          <td><label  for='secondary_language'>Secondary Language</label></td>
          <td > <input class='textbox' type='text' name='secondary_language' id='secondary_language' size='30' value= '' /></td>
           <td></td>
      </tr>
      </tr>
          <tr>     
          <td><label  for='trans_language'>Translation Language<br>needed during conference</label></td>
          <td > <input class='textbox' type='text' name='trans_language' id='t_language' size='30' value= '' /></td>
          <td></td>
      </tr>
    </tr>
     <tr>     
          <td><label  for='comments'>Program Code</label></td>
          <td > <input class='textbox' type='text' name='t_coupon' id='t_coupon' size='15' value= 'STANDARD' /></td>
          <td></td>
      </tr> 
          <tr>     
          <td><label  for='comments'>Comments</label></td>
          <td > <textarea class='textbox' name='comments' cols='50'>
          </textarea> </td>
          <td></td>
      </tr>
  </table>
        <p  align='center'>* Required field.</p>
        <p align='center'><input class='btn large blue' type='submit' name='action' value='Add this Person to Registration' />     </p>           
    </form> 
      <p align='center'>Or </p>
    </div> 
     
                
    </div>    
    ";
}
function render_bulk_form ()
{
        
    //invoking country function //
     
    echo " 
     <tr>     
         <td colspan=3>
          <center>
	          <table >
	          <tr>     
	           <td><label for='recordings'><a href='http://www.ispectraignite.org/'>  iSpectra Conference April 24-26, $79&nbsp;</a>
	            <input type='hidden' name='adult' id='adult'  value='groupadult'  /> </label></td>
	          
	       
	           </tr>
	           </table>
	         </td>
	         </center>
	       </tr>
     <tr>
     <tr>
     	<td><label  for='first_name'>* First Name</label></td>
        <td ><input class='textbox' type='text' name='first_name' id='first_name' size='30' value= '' /></td>
       	<td></td>
    </tr>
     <tr>     
  	    <td><label class='field'  for='last_name'>* Last Name</label></td>
	    <td><input class='textbox' type='text' name='last_name' id='last_name' size='40' value= '' /></td>
     	<td></td>
      </tr>
       <tr>
          <td><label class='field' for='email'> * Email Address  </label></td>
          <td ><input class='textbox' type='text' name='email' id='email' size='40' value= '' /></td>
          <td></td>
       </tr> 
            <input type='hidden' name='adultchild' id='adultchild' value= 'ADULT' />
					     <!--tr> 
					         <td><label  for='Adult or Child'>*  Adult or Child (Grades 1-6) </label></td>
					         <td >Adult<input class='radio' type='radio' name='adultchild' id='adultchild' value= 'ADULT' />
					              &nbsp;&nbsp;&nbsp;
					          Child<input class='radio' type='radio' name='adultchild' id='adultchild' value= 'CHILD' /></td>                          
					      </tr-->
        <tr>
          <td><label class='field' for='church'>* Church/Organization</label></td>
          <td ><input class='textbox' type='text' name='church' id='church' size='50' value= '' /></td>
          <td></td>
        </tr> 
      
     
          <td><label  for='Count'>* Number to Purchase (minimum 10)</label></td>
          <td > <input class='textbox' type='text' name='count' id='count' size='30' value= '10' /></td>
          <td></td>
      </tr>
               <tr>     
          <td><label  for='comments'>Comments</label></td>
          <td > <textarea class='textbox' name='comments' cols='50'>
          </textarea> </td>
          <td></td>
      </tr>
  </table>
        <p  align='center'>* Required field.</p>
        <p align='center'><input class='btn large blue' type='submit' name='action' value='Submit Registration' />     </p>           
    </form> 
      <p align='center'>Or </p>
    </div> 
     
                
    </div>    
    ";
}

function render_input_form_check()
{
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
    
    return " 
    <div class='section'>
    <form method='post' action='placeOrder.php' id='place_order'>
    
    <table cellpadding='4' align='center'>
        <tr>
            <td><label class='required' for='first'>* First Name</label></td>
            <td ><input class='textbox' type='text' name='first' id='first' size='40' value= '$first_name' /></td>
        </tr>
        <tr>
            <td><label class='required' for='last'>* Last Name</label></td>
            <td ><input class='textbox' type='text' name='last' id='last' size='40' value= '$last_name' /></td>
        </tr>
        <tr>
            <td><label class='required' for='address'>* Address Line 1</label></td>
            <td ><input class='textbox' type='text' name='address1' id='address1' size='40' value= '$address_first' /></td>
        </tr>
        <tr>
            <td><label class='field' for='address'>&nbsp;&nbsp;Address Line 2</label></td>
            <td ><input class='textbox' type='text' name='address2' id='address2' size='40' value= '$address_second' /></td>
        </tr>
        <tr>
            <td><label class='required' for='city'>* City</label></td>
            <td ><input class='textbox' type='text' name='city' id='city' size='40' value= '$city_name' /></td>
        </tr>
        <tr>
            <td><label class='required' for='state'>* State</label></td>
            <td >
                <input class='textbox' type='text' name='state' id='state' size='2' value= '$state_name' />
                <label class='required' for='zip'>&nbsp;&nbsp;<strong>* Zip</strong>&nbsp;</label>
                <input class='textbox' type='text' name='zip' id='zip' size='10' value= '$zip_code' />
            </td>
        </tr>
        <tr>
            <td><label class='required' for='phone'>* Phone</label></td>
            <td >
            <input class='textbox' type='text' name='night_phone_a' id='night_phone_a' size='3' value='$phone_area_code'/>
            <!--<label class='field'>&nbsp;&nbsp;</label>
            <input class='textbox' type='text' name='night_phone_b' id='night_phone_b' size='3'value='$phone_prefix' />
            <label class='field'>&nbsp;&nbsp;</label>
            <input class='textbox' type='text' name='night_phone_c' id='night_phone_c' size='4' value='$phone_postfix'/>--></td>
        </tr>
        <tr>
            <td><label class='required' for='email'>* Email Address</label></td>
            <td ><input class='textbox' type='text' name='email' id='email' size='40' value= '$email_address'/></td>
        </tr>                               
        <tr>                        
        </tr>
    </table>
            <p class='required' align='center'>* Required field.</p>
            <p align='center'><input class='btn large green' type='submit' name='submit' value='SUBMIT ORDER'/>     </p>           
    </form> 
        
    </div> 
    <br />
    ";  
}

function render_special_form ()
{
    echo " 
    <tr>
        <td><label  for='first_name'>* First Name</label></td>
        <td ><input class='textbox' type='text' name='first_name' id='first_name' size='30' value= '' /></td>
     </tr>
    <tr>     
        <td><label  for='last_name'>* Last Name</label></td>
        <td > <input class='textbox' type='text' name='last_name' id='last_name' size='30' value= '' /></td>
    </tr>
     <tr>
      <td><label class='field' for='address'> Address Line 1</label></td>
      <td ><input class='textbox' type='text' name='address1' id='address1' size='40' value= '' /></td>
      <td>
    </tr>
    <tr>
        <td><label class='field' for='address'>&nbsp;&nbsp;Address Line 2</label></td>
        <td ><input class='textbox' type='text' name='address2' id='address2' size='40' value= '' /></td>
    </tr>
    <tr>
        <td><label class='field' for='city'> City</label></td>
        <td ><input class='textbox' type='text' name='city' id='city' size='40' value= '' /></td>
    </tr>
    <tr>
        <td><label class='field' for='state'> State</label></td>
        <td >
            <input class='textbox' type='text' name='state' id='state' size='2' value= '' />
            <label class='field' for='zip'>&nbsp;&nbsp;<strong> Zip</strong>&nbsp;</label>
            <input class='textbox' type='text' name='zip' id='zip' size='10' value= '' />
        </td>
    </tr>
        <tr>
            <td><label class='field' for='email'>* Email Address  </label></td>
            <td ><input class='textbox' type='text' name='email' id='email' size='40' value= '' /></td>
        </tr> 
        <tr>
        <td><label class='field' for='church'>Your Church or Organization Name and city </label></td>
        <td ><input class='textbox' type='text' name='church' id='church' size='50' value= '' /></td>
    </tr> 
        
        
  </table>
    <p  align='center'>* Required field.</p>
    <p align='center'><input class='btn large blue' type='submit' name='action' value='Add this Person to Registration' />     </p>           
  </form> 
      <p align='center'>Or </p>
</div> 
                     
                    
</div>    
";
}


 


function countryArray($name, $selected)
{
    $country_Array = array('US' =>'United States','AF' => 'Afghanistan', 'AL' => 'Albania', 'DZ' =>
        'Algeria', 'AS' => 'American Samoa', 'AD' => 'Andorra', 'AO' => 'Angola', 'AI' =>
        'Anguilla', 'AQ' => 'Antarctica', 'AG' => 'Antigua and Barbuda', 'AR' =>
        'Argentina', 'AM' => 'Armenia', 'AW' => 'Aruba', 'AU' => 'Australia', 'AT' =>
        'Austria', 'AZ' => 'Azerbaijan', 'BS' => 'Bahamas', 'BH' => 'Bahrain', 'BD' =>
        'Bangladesh', 'BB' => 'Barbados', 'BY' => 'Belarus', 'BE' => 'Belgium', 'BZ' =>
        'Belize', 'BJ' => 'Benin', 'BM' => 'Bermuda', 'BT' => 'Bhutan', 'BO' =>
        'Bolivia', 'BA' => 'Bosnia and Herzegowina', 'BW' => 'Botswana', 'BV' =>
        'Bouvet Island', 'BR' => 'Brazil', 'IO' => 'British Indian Ocean Territory',
        'BN' => 'Brunei Darussalam', 'BG' => 'Bulgaria', 'BF' => 'Burkina Faso', 'BI' =>
        'Burundi', 'KH' => 'Cambodia', 'CM' => 'Cameroon', 'CA' => 'Canada', 'CV' =>
        'Cape Verde', 'KY' => 'Cayman Islands', 'CF' => 'Central African Republic', 'TD' =>
        'Chad', 'CL' => 'Chile', 'CN' => 'China', 'CX' => 'Christmas Island', 'CC' =>
        'Cocos (Keeling) Islands', 'CO' => 'Colombia', 'KM' => 'Comoros', 'CG' =>
        'Congo', 'CD' => 'Congo, the Democratic Republic of the', 'CK' => 'Cook Islands',
        'CR' => 'Costa Rica', 'CI' => 'Cote d&#39Ivoire', 'HR' => 'Croatia (Hrvatska)',
        'CU' => 'Cuba', 'CY' => 'Cyprus', 'CZ' => 'Czech Republic', 'DK' => 'Denmark',
        'DJ' => 'Djibouti', 'DM' => 'Dominica', 'DO' => 'Dominican Republic', 'TP' =>
        'East Timor', 'EC' => 'Ecuador', 'EG' => 'Egypt', 'SV' => 'El Salvador', 'GQ' =>
        'Equatorial Guinea', 'ER' => 'Eritrea', 'EE' => 'Estonia', 'ET' => 'Ethiopia',
        'FK' => 'Falkland Islands (Malvinas)', 'FO' => 'Faroe Islands', 'FJ' => 'Fiji',
        'FI' => 'Finland', 'FR' => 'France', 'FX' => 'France, Metropolitan', 'GF' =>
        'French Guiana', 'PF' => 'French Polynesia', 'TF' =>
        'French Southern Territories', 'GA' => 'Gabon', 'GM' => 'Gambia', 'GE' =>
        'Georgia', 'DE' => 'Germany', 'GH' => 'Ghana', 'GI' => 'Gibraltar', 'GR' =>
        'Greece', 'GL' => 'Greenland', 'GD' => 'Grenada', 'GP' => 'Guadeloupe', 'GU' =>
        'Guam', 'GT' => 'Guatemala', 'GN' => 'Guinea', 'GW' => 'Guinea-Bissau', 'GY' =>
        'Guyana', 'HT' => 'Haiti', 'HM' => 'Heard and Mc Donald Islands', 'VA' =>
        'Holy See (Vatican City State)', 'HN' => 'Honduras', 'HK' => 'Hong Kong', 'HU' =>
        'Hungary', 'IS' => 'Iceland', 'IN' => 'India', 'ID' => 'Indonesia', 'IR' =>
        'Iran (Islamic Republic of)', 'IQ' => 'Iraq', 'IE' => 'Ireland', 'IL' =>
        'Israel', 'IT' => 'Italy', 'JM' => 'Jamaica', 'JP' => 'Japan', 'JO' => 'Jordan',
        'KZ' => 'Kazakhstan', 'KE' => 'Kenya', 'KI' => 'Kiribati', 'KP' =>
        'Korea, Democratic People&#39s Republic of', 'KR' => 'Korea, Republic of', 'KW' =>
        'Kuwait', 'KG' => 'Kyrgyzstan', 'LA' => 'Lao People&#39s Democratic Republic',
        'LV' => 'Latvia', 'LB' => 'Lebanon', 'LS' => 'Lesotho', 'LR' => 'Liberia', 'LY' =>
        'Libyan Arab Jamahiriya', 'LI' => 'Liechtenstein', 'LT' => 'Lithuania', 'LU' =>
        'Luxembourg', 'MO' => 'Macau', 'MK' =>
        'Macedonia, The Former Yugoslav Republic of', 'MG' => 'Madagascar', 'MW' =>
        'Malawi', 'MY' => 'Malaysia', 'MV' => 'Maldives', 'ML' => 'Mali', 'MT' =>
        'Malta', 'MH' => 'Marshall Islands', 'MQ' => 'Martinique', 'MR' => 'Mauritania',
        'MU' => 'Mauritius', 'YT' => 'Mayotte', 'MX' => 'Mexico', 'FM' =>
        'Micronesia, Federated States of', 'MD' => 'Moldova, Republic of', 'MC' =>
        'Monaco', 'MN' => 'Mongolia', 'MS' => 'Montserrat', 'MA' => 'Morocco', 'MZ' =>
        'Mozambique', 'MM' => 'Myanmar', 'NA' => 'Namibia', 'NR' => 'Nauru', 'NP' =>
        'Nepal', 'NL' => 'Netherlands', 'AN' => 'Netherlands Antilles', 'NC' =>
        'New Caledonia', 'NZ' => 'New Zealand', 'NI' => 'Nicaragua', 'NE' => 'Niger',
        'NG' => 'Nigeria', 'NU' => 'Niue', 'NF' => 'Norfolk Island', 'MP' =>
        'Northern Mariana Islands', 'NO' => 'Norway', 'OM' => 'Oman', 'PK' => 'Pakistan',
        'PW' => 'Palau', 'PA' => 'Panama', 'PG' => 'Papua New Guinea', 'PY' =>
        'Paraguay', 'PE' => 'Peru', 'PH' => 'Philippines', 'PN' => 'Pitcairn', 'PL' =>
        'Poland', 'PT' => 'Portugal', 'PR' => 'Puerto Rico', 'QA' => 'Qatar', 'RE' =>
        'Reunion', 'RO' => 'Romania', 'RU' => 'Russian Federation', 'RW' => 'Rwanda',
        'KN' => 'Saint Kitts and Nevis', 'LC' => 'Saint LUCIA', 'VC' =>
        'Saint Vincent and the Grenadines', 'WS' => 'Samoa', 'SM' => 'San Marino', 'ST' =>
        'Sao Tome and Principe', 'SA' => 'Saudi Arabia', 'SN' => 'Senegal', 'SC' =>
        'Seychelles', 'SL' => 'Sierra Leone', 'SG' => 'Singapore', 'SK' =>
        'Slovakia (Slovak Republic)', 'SI' => 'Slovenia', 'SB' => 'Solomon Islands',
        'SO' => 'Somalia', 'ZA' => 'South Africa', 'GS' =>
        'South Georgia and the South Sandwich Islands', 'ES' => 'Spain', 'LK' =>
        'Sri Lanka', 'SH' => 'St. Helena', 'PM' => 'St. Pierre and Miquelon', 'SD' =>
        'Sudan', 'SR' => 'Suriname', 'SJ' => 'Svalbard and Jan Mayen Islands', 'SZ' =>
        'Swaziland', 'SE' => 'Sweden', 'CH' => 'Switzerland', 'SY' =>
        'Syrian Arab Republic', 'TW' => 'Taiwan, Province of China', 'TJ' =>
        'Tajikistan', 'TZ' => 'Tanzania, United Republic of', 'TH' => 'Thailand', 'TG' =>
        'Togo', 'TK' => 'Tokelau', 'TO' => 'Tonga', 'TT' => 'Trinidad and Tobago', 'TN' =>
        'Tunisia', 'TR' => 'Turkey', 'TM' => 'Turkmenistan', 'TC' =>
        'Turks and Caicos Islands', 'TV' => 'Tuvalu', 'UG' => 'Uganda', 'UA' =>
        'Ukraine', 'AE' => 'United Arab Emirates', 'GB' => 'United Kingdom', 'US' =>
        'United States', 'UM' => 'United States Minor Outlying Islands', 'UY' =>
        'Uruguay', 'UZ' => 'Uzbekistan', 'VU' => 'Vanuatu', 'VE' => 'Venezuela', 'VN' =>
        'Viet Nam', 'VG' => 'Virgin Islands (British)', 'VI' => 'Virgin Islands (U.S.)',
        'WF' => 'Wallis and Futuna Islands', 'EH' => 'Western Sahara', 'YE' => 'Yemen',
        'YU' => 'Yugoslavia', 'ZM' => 'Zambia', 'ZW' => 'Zimbabwe');
    $str = "<select name=".$name." class=".$name.">";
 
    foreach ($country_Array as $key => $value) {
     
      /*  if ($selected == $key) {
            $thisExtra = " SELECTED"; 
        } else {
            
        }*/
         $str .= "<option value=".$key.">" . stripslashes($value) .
            "</option>n";
  
 
    
             
    }
        
 
    $str .= "</select>";
 
    return $str;
    
    }

function render_register($gcode)
{
    $register = get_register_session($gcode);
    
    if ($register == FALSE)
    {
        $output = "<table class='products'><tr>";
        $output .= "<td>No products to display!</td>";
        $output .= "</tr></table>";
    }
    else
    {
        $output = "
        
        <table class='shoppingCart'>
        <tr><th colspan=3>Registerant Details (Click to Edit)</th></tr>
        ";
    
        foreach ($register as $r)
        {
        	$id=$r['id'];
            $output .= "
            <tbody>
                <tr id=$id  class='edit_tr'>
              
               <td width='33%' class='edit_td'>
				<span id='first_$id' class='text'> ".$r['first_name']."</span>
					<input type='text' value=".$r['first_name']." class='editbox' id='first_input_$id' />
				</td>
				 <td class='edit_td'>
				<span width='33%' id='last_$id' class='text'> ".$r['last_name']."</span>
					<input type='text' value=".$r['last_name']." class='editbox' id='last_input_$id' />
				</td>
             
               <td width='33%' class='edit_td'>
          	      <span id='email_$id' class='text'> ".$r['email']."</span>
          	      	<input type='text' value=".$r['email']." class='editbox' id='email_input_$id' />
				
               </td>               
           
                
               </tr>
               </tbody>
            ";
        }
        $output .= "</table>";
        return $output;
    }
}
?>

 
 