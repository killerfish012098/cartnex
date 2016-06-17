<?php
class SubTotal_Class
{
    public function __construct() 
    {
   
    }
    
    public function applyRule(&$cartRule) 
    {
        $app=Yii::app();
        $subTotal=$app->cart->getSubTotal();
        $cartRule['cartRule'][] = array(
                'code'       => 'SUBTOTAL',
                'label'      => 'Sub Total : ',
                'text'       => $app->currency->format($subTotal),//$this->currency->format(max(0, $cartRule['total'])),
                'value'      => $subTotal,//max(0, $total),
                'sort_order' => (int)Yii::app()->config->getData('CARTRULE_SUBTOTAL_SORT_ORDER')
            );
        
        $cartRule['total']+=$subTotal;
    }
}