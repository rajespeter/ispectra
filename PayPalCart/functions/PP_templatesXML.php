<?php
function render_header($title = 'Engage Conference Registration') {
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

    <div id="midBanner">
        <img src="../../images/Engage-logo_with_tag_line.png" width="960" height="150" alt="Welcome to Engage for God" />
    </div>
            
    <div class="wrapper">
       <!--  <div class="nav">
            <a href="../../exhibitors.php">back to registration</a>
            <a href="viewCart.php">View Cart</a>
            <a href="clearCart.php?clear=1">Clear Cart</a>
            <a href="index.php?clear=1">Clear Cart</a>             
        </div> -->       
';        
} 

function render_footer() {
     return '
         

     <div id="footer">
         <p  align="center"> 
             <a href="../../index.php" title="Engage Home page"> Return to Engage Home page </a>
             </p>
        <p >&copy; The Harvest Group &nbsp;&nbsp; 
        <a href="../../privacy.htm" target="_blank" >Privacy Policy</a> | 
        <a href="../../terms.htm" target="_blank" >Terms and Conditions</a> | 
        <a href="../../contact.php" title="contact us"  target="_blank" > Contact Us </a>
        </p>
</div>
    </div>
    
 </div> <!-- outerDiv -->

 </body>

</html>';
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

// Shopping cart templates

function render_shopping_cart_row(ShoppingCart $shopping_cart , $product_id , $line_item_counter) 
{
           
       $quantity = $shopping_cart->GetItemQuantity($product_id);  
       
       $amount = $shopping_cart->GetItemCost($product_id); 
       
       $unit_cost = get_item_cost($product_id);
       
       $shipping_amount = 0.00;
        
       $output = " 
        <tr>
            <td>
                $product_id
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
            $ ".$shopping_cart->GetTotal()."
             </td>        
        </tr>    
        ";   
}

function render_shopping_cart(ShoppingCart $shopping_cart) 
{
    $output="<table class='shoppingCart' >
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
    $output .= render_shopping_cart_total_row($shopping_cart);
    $output .= "</table>";

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
    
     $quantity_adults = $shopping_cart->GetItemQuantity($product_id = "ADULT") ;
     if($quantity_adults >= 5) {
        $discount_group = $quantity_adults*20.00; 
         echo "You have registered 5 or more Adults, the discout will be aplied when you go to pay";
     } else{
       $discount_group = 0;  
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

        " .render_shopping_cart($shopping_cart).  "
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
        
        <input type='hidden' name='notify_url' value=' " .PAYPAL_IPN_RETURN_URL. "  '>
        <input type='hidden' name='return' value=' " .PAYPAL_CHECKOUT_COMPLETE_URL. " '>
        <input type='hidden' name='rm' value='2'>
        <input type='hidden' name='cbt' value='Return to The Store'>
        <input type='hidden' name='cancel_return' value='  " .PAYPAL_CANCEL_CHECKOUT_URL. "  '>

    <input type='image' src='https://www.paypal.com/en_US/i/btn/btn_paynowCC_LG.gif' border='0' name='submit' alt='PayPal - The safer, easier way to pay online!'>
    <img alt='' border='0' src='https://www.paypal.com/en_US/i/scr/pixel.gif' width='1' height='1'>

</form>";
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
    
    return " <div class='section'>
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
                        <input class='textbox' type='text' name='night_phone_a' id='night_phone_a' size='3' value= '$phone_area_code' />
                        <label class='field'>&nbsp;&nbsp;</label>
                        <input class='textbox' type='text' name='night_phone_b' id='night_phone_b' size='3'value= '$phone_prefix'  />
                        <label class='field'>&nbsp;&nbsp;</label>
                        <input class='textbox' type='text' name='night_phone_c' id='night_phone_c' size='4' value= '$phone_postfix' /></td>
                    </tr>
                    <tr>
                        <td><label class='required' for='email'>* Email Address</label></td>
                        <td ><input class='textbox' type='text' name='email' id='email' size='40' value= '$email_address' /></td>
                    </tr>                               
                    <tr>                        
                    </tr>
                </table>
                    <p class='required' align='center'>* Required field.</p>
                    <p align='center'><input class='btn large green' type='submit' name='submit' value='SUBMIT ORDER' />     </p>           
            </form> 
                
            </div> 
            <br />
            ";
 
}

function render_agency_form()
{
    echo "
        <div>
            <div class='section'>
                    <form method='post' action='exhibitors_reg.php' id='add_names'>
                    <h4> Please Fill in information about your organization </h4>
                        <table cellpadding='4' align='center'>
                </tr>
                          <tr>
                                <td><label class='required' for='agency'>* Your Agency or Organizations Name</label></td>
                                <td ><input class='textbox' type='text' name='agency_name' id='agency_name' size='25' value= '$agency_name' /></td>
                           </tr>
                           <tr>
                            <td><label class='required' for='address'>* Address Line 1</label></td>
                            <td ><input class='textbox' type='text' name='ag_address1' id='ag_address1' size='40' value= '$ag_address_first' /></td>
                        </tr>
                        <tr>
                            <td><label class='field' for='address'>&nbsp;&nbsp;Address Line 2</label></td>
                            <td ><input class='textbox' type='text' name='ag_address2' id='ag_address2' size='40' value= '$ag_address_second' /></td>
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
                            <input class='textbox' type='text' name='ag_night_phone_a' id='ag_night_phone_a' size='3' value= '$ag_phone_area_code' />
                            <label class='field'>&nbsp;&nbsp;</label>
                            <input class='textbox' type='text' name='ag_night_phone_b' id='ag_night_phone_b' size='3'value= '$ag_phone_prefix'  />
                            <label class='field'>&nbsp;&nbsp;</label>
                            <input class='textbox' type='text' name='ag_night_phone_c' id='ag_night_phone_c' size='4' value= '$ag_phone_postfix' /></td>
                        </tr>
                        <tr>
                            <td><label class='required' for='email'>* Email Address</label></td>
                            <td ><input class='textbox' type='text' name='ag_email' id='ag_email' size='40' value= '$ag_email_address' /></td>
                        </tr>                               
                        <tr>                        
                        </tr>
                    </table>
                        <p class='required' align='center'>* Required field.</p>
                        <p align='center'><input class='btn large blue' type='submit' name='register' value='Register Your Agency' />     </p>       
                        
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
                </tr>
                          <tr>
                                <td><label class='required' for='agency'>* Your Agency or Organizations Name</label></td>
                                <td ><input class='textbox' type='text' name='agency_name' id='agency_name' size='25' value= '$agency_name' /></td>
                           </tr>
                           <tr>
                            <td><label class='required' for='address'>* Address Line 1</label></td>
                            <td ><input class='textbox' type='text' name='ag_address1' id='ag_address1' size='40' value= '$ag_address_first' /></td>
                        </tr>
                        <tr>
                            <td><label class='field' for='address'>&nbsp;&nbsp;Address Line 2</label></td>
                            <td ><input class='textbox' type='text' name='ag_address2' id='ag_address2' size='40' value= '$ag_address_second' /></td>
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
                            <input class='textbox' type='text' name='ag_night_phone_a' id='ag_night_phone_a' size='3' value= '$ag_phone_area_code' />
                            <label class='field'>&nbsp;&nbsp;</label>
                            <input class='textbox' type='text' name='ag_night_phone_b' id='ag_night_phone_b' size='3'value= '$ag_phone_prefix'  />
                            <label class='field'>&nbsp;&nbsp;</label>
                            <input class='textbox' type='text' name='ag_night_phone_c' id='ag_night_phone_c' size='4' value= '$ag_phone_postfix' /></td>
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
    echo " 
    
                        <tr>
                            <td><label for='first_name'>* First Name</label></td>
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
                            <td><label class='field' for='email'> Email Address  </label></td>
                            <td ><input class='textbox' type='text' name='email' id='email' size='40' value= '' /></td>
                        </tr> 
                        <tr> 
                           <td><label  for='Adult or Child'>*  Adult or Child (Grades 1-6) </label></td>
                            <td >Adult<input class='radio' type='radio' name='adultchild' id='adultchild' value= 'ADULT' />
                                &nbsp;&nbsp;&nbsp;
                            Child<input class='radio' type='radio' name='adultchild' id='adultchild' value= 'CHILD' /></td>                          
                        </tr>
                        <tr>
                        <td><label class='field' for='church'>Your Church or Organization Name and city </label></td>
                        <td ><input class='textbox' type='text' name='church' id='church' size='50' value= '' /></td>
                    </tr> 
                        <tr>     
                            <td><label class='field' for='recordings'>Add Recordings for $30 </label></td>
                            <td > <input class='' type='checkbox' name='recordings' id='recordings' size='25' value= 'RECORDINGS' /></td>
                        </tr>
                        
            </table>
                            <p align='center'>* Required field.</p>
                            <p align='center'><input class='btn large blue' type='submit' name='action' value='Add this Person to Registration' />     </p>           
                    </form> 
                        <p align='center'>Or </p>
                    
             <!--       <p class='nav' align='center'><a href='clearCart.php?clear=1'>Cancel and Clear Cart</a><br /></p> -->
                    </div> 
                     
                    
        </div>    
        ";
}
?>