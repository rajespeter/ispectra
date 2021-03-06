<?php
function render_header($title = 'Engage Conference Registration') {
return '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <title>'.$title.'</title>
        
        <link href="http://engageforgod.com/css/main.css" rel="stylesheet" type="text/css" />
        

    </head>

    <body>   

<div id="outerDiv">

    <div id="header">
        <div id="contactButton">
            <a href="contact.php" title="contact us"  target="_blank" > </a>
        </div>
        
        <div id="homeButton">
            <a href="http://engageforgod.com/index.php" title="The Harvest Group Home page"></a>
        </div>
                 


        
    </div> <!-- header -->

    <div id="midBanner">
        <img src="http://engageforgod.com/images/Engage-logo_with_tag_line.png" width="960" height="220" alt="Welcome to Engage for God" />
    </div>
            
    <div class="wrapper">
        <div class="nav">
            <a href="http://engageforgod.com/exhibitors.php">back to registration</a>
            <a href="viewCart.php">View Cart</a>
            <a href="index.php?clear=1">Clear Cart</a>
            
            
        </div>
';        
} 

function render_footer() {
     return '
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
  
    $output .= render_shopping_cart_shipping_row($shopping_cart); 
    //$output .= render_shopping_cart_total_row($shopping_cart);
    $output .= "</table>
";

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
   
    echo "<div class='left'>" ;
    echo $first_name . " " . $last_name ."<br />";
    echo $address_first ."<br />";
    if ($address_second != "") {echo $address_second ."<br />"; }  
    echo $city_name . ", " . $state_name . ", " . $zip_code  ."<br />";
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





?>