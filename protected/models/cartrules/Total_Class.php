<?php
class Total_Class
{
    public function __construct() 
    {
      //  echo 'total<br/>';
    }

    public function applyRule(&$cartRule) 
    {
        //echo '<pre>';print_r($cartRule);echo '</pre>';
        $cartRule['cartRule'][] = array(
			'code'       => 'TOTAL',
			'label'      => 'Total : ',
			'text'       => Yii::app()->currency->format($cartRule['total']),//$this->currency->format(max(0, $cartRule['total'])),
			'value'      => $cartRule['total'],//max(0, $total),
			'sort_order' => (int)Yii::app()->config->getData('CARTRULE_TOTAL_SORT_ORDER')
                    );
    }
}