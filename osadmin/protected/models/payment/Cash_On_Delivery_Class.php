<?php
Class Cash_On_Delivery_Class
{
    public $code;
    public $tax;
    public $region;
    public $sort_order;
    public $order_status_id;
    public $status;
    public $title;
    
    public function __construct() 
    {
        $this->code='COD';
    }
    
    public function define()
    {
        $this->tax=Yii::app()->config()->getData('PAYMENT_'.$this->code.'_TAX_CLASS');
        $this->sort_order=Yii::app()->config()->getData('PAYMENT_'.$this->code.'_SORT_ORDER');
        $this->region=Yii::app()->config()->getData('PAYMENT_'.$this->code.'_REGION');
        $this->status=Yii::app()->config()->getData('PAYMENT_'.$this->code.'_STATUS');
        $this->title=Yii::app()->config()->getData('PAYMENT_'.$this->code.'_TITLE');
        $this->order_status_id=Yii::app()->config()->getData('PAYMENT_'.$this->code.'_ORDER_STATUS_ID');
    }
    
    Public function isAllowed()
    {
        //will check some conditions if payment gatewaye is applied or not based on user selection
        return true;
    }
    
    
    public function renderData() //will be called in confirm page
    {

    }
    
    public function beforeOrderProcess() // after order before insertion
    {

    }
    
    public function afterOrderProcess() //after order after insertion
    {

    }
}