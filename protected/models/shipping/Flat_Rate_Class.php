<?php
Class Flat_Rate_Class
{
    public $code;
    public $tax;
    public $region;
    public $sort_order;
    public $status;
    public $title;
    
    public function __construct() 
    {
        $this->code='FLAT';
    }
    
    public function define()
    {
        $this->tax=Yii::app()->config->getData('SHIPPING_'.$this->code.'_TAX_CLASS');
        $this->sort_order=Yii::app()->config->getData('SHIPPING_'.$this->code.'_SORT_ORDER');
        $this->region=Yii::app()->config->getData('SHIPPING_'.$this->code.'_REGION');
        $this->status=Yii::app()->config->getData('SHIPPING_'.$this->code.'_STATUS');
    }
    
    Public function isAllowed()
    {
        //will check some conditions if payment gatewaye is applied or not based on user selection
        return true;
    }
    
    public function getQuote()
    {
		//echo "value of flat cost ".Yii::app()->config->getData('SHIPPING_FLAT_COST');
        $this->quotes = array( 
                              'title' => 'Flat Rate Shipping',
                              'methods' => array($this->code=>
                                                array('code' => $this->code.'-'.$this->code,
                                                      'title' => 'Best Way',
                                                      'cost' => Yii::app()->config->getData('SHIPPING_FLAT_COST'),
													  'label'=>'$5',	
                                                      )
                                                ),
								'error'=>'',
                             );

      return $this->quotes;
    }
}