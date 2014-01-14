<?php

class ShoppingCart {
    protected $items = array();
    private $names = array();
    private $codes = array();
    private $coupons =0;
    
	public function AddCoupon($coupon){
		$this->coupons += $coupon ;
	  
	}
	public function GetCoupon(){
		return $this->coupons;
		
	}
	public function AddCouponCode($code){
		 $a =array_push($this->codes, $code) ;
	     return $a;
	}
	public function GetCouponCode(){
		return $this->codes;
		
	}
	
    public function addNames($fullname){
       
       $a = array_push($this->names, $fullname)  ;
       return $a; 
    }
    
    public function listNames(){
        
      return $this->names;
    }
    
    
    public function AddItem($product_id) 
    {
              
        if (array_key_exists($product_id , $this->items)) 
            $this->items[$product_id] = $this->items[$product_id] + 1;
         else {
            $this->items[$product_id] = 1;
         }   
    }
    

    public function CheckItem($product_id) 
    {
              
        if (array_key_exists($product_id , $this->items)) 
            return 1;
         else {
            return 0;
         }   
    }
    
    public function GetItemCost($product_id)
    {
        $cost_string = get_item_cost($product_id);
        $cost_float = "$cost_string" + 0;
        
        return $cost_float * $this->GetItemQuantity($product_id);
    }
    
    public function GetTotal()
    {
        // add tax here
        // add shipping here
        
       $coupon_value = $this->GetCoupon();
	  
        return $this->GetSubTotal() + $this->GetShippingCost() -$coupon_value; 
        
    }
    
	
    public function GetSubTotal() {
        $total=0;
        foreach ($this->items as $product_id => $quantity) 
            $total = $total + $this->GetItemCost($product_id);
        
        return $total;
    }
    
    public function GetShippingCost() {
        $total = 0;
        //foreach($this->items as $product_id => $quantity )
        //    $total = $total + $this->GetItemShippingCost($product_id);
        
        return $total;
    }
    
    
    public function GetItems() {
        return array_keys($this->items);
    }
    
    public function GetItemQuantity($product_id) {
  
        return intval($this->items[$product_id]);
    }
    
    public function EmptyCart() {
        $this->items = array();
        $this->names = array();
		$this->coupons = 0;
		$this->codes = array();
   
    }
    
    
    
}
    
?>