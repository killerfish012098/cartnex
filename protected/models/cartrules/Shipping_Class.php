<?php
class Shipping_Class
{
    public function __construct() 
    {
      //  echo 'total<br/>';
    }

    public function applyRule(&$cartRule) 
    {
		$app=Yii::app();
		if ($app->cart->hasShipping() && isset($_SESSION['shipping_method'])) {

			/*if ($this->session->data['shipping_method']['tax_class_id']) {
				$tax_rates = $this->tax->getRates($this->session->data['shipping_method']['cost'], $this->session->data['shipping_method']['tax_class_id']);

				foreach ($tax_rates as $tax_rate) {
					if (!isset($taxes[$tax_rate['tax_rate_id']])) {
						$taxes[$tax_rate['tax_rate_id']] = $tax_rate['amount'];
					} else {
						$taxes[$tax_rate['tax_rate_id']] += $tax_rate['amount'];
					}
				}
			}*/

			$cartRule['cartRule'][] = array(
					'code'       => 'SHIPPING',
					'label'      => $_SESSION['shipping_method']['title'],
					'text'       => $app->currency->format($_SESSION['shipping_method']['cost']),
					'value'      => $_SESSION['shipping_method']['cost'],
					'sort_order' => (int)Yii::app()->config->getData('CARTRULE_SHIPPING_SORT_ORDER')
							);
			$cartRule['total']+=$_SESSION['shipping_method']['cost'];
		}
    }
}