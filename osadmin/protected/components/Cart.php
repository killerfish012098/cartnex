<?php
class Cart 
{
    public $weight;
    
    public function init() 
    {
            
    }
    
    public function calculateWeight()
    {

    }
    
    public function hasShipping() 
    {
        $shipping = false;
        foreach ($this->getProducts() as $product) {
            if ($product['shipping']) {
                $shipping = true;

                break;
            }
        }

        return $shipping;
    }
    
    public function getCartVolume() { //total items in cart
        $product_total = 0;

        $products = $this->getProducts();

        foreach ($products as $product) {
            //$product_total += $product['quantity'];
            $product_total += $product['quantity'];
        }

        return $product_total;
    }
}