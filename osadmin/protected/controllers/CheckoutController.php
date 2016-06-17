<?php

class CheckoutController extends Controller {

    

    public function getWeight() {
        $weight = 0;
        $wtObj = new Model_Weight();

        foreach ($this->getProducts() as $product) {
            if ($product['shipping']) {
                $weight += $wtObj->convert($product['weight'],
                        $product['weight_class'], DEFAULT_WEIGHT_CLASS);
            }
        }

        return $weight;
    }

    

    public function isLogged() {
        return $this->customer_id;
    }

    public function actionorderdetails() {
        
    }

    public function actionordermethod() 
    {
        if ($this->customer->isLogged())
        $hasShipping = Yii::app()->cart->hasShipping(); //1 if yes,0 if no
        Yii::app()->cart->calculateWeight();
        
        $this->data['shipping']=$hasShipping?array('hasShipping'=>'1','shipping'=>Yii::app()->shipping->getMethods()):array('hasShipping'=>0);
        $this->data['payment']=Yii::app()->payment->getMethods();
        $this->data['terms']=Yii::app()->config->getData['CONFIG_STORE_CHECKOUT_TERMS']!=0?'i have read and agree to the terms & conditions':"";
        
        if ($hasShipping) 
        {
            if ($this->customer->isLogged()) {
                $shipping_address = $this->accAddr->getAddress($_SESSION['shipping_address_id']);
            } elseif (isset($_SESSION['guest'])) {
                $shipping_address = $_SESSION['guest']['shipping'];
            }

            if (!isset($shipping_address)) {
                $json['redirect'] = Model_Url::getLink(array("controller" => "checkout",
                            "action" => "checkout"), '', SERVER_SSL);
            }
        }
    }
}