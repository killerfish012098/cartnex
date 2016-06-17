<?php
class Coupon_Class
{
    public function __construct() 
    {
   
    }

	public function applyRule(&$cartRule) {
		if (isset($_SESSION['coupon_code'])) {
		$app=Yii::app();
			$coupon_info = $this->getCoupon($_SESSION['coupon_code']);
			$_SESSION['coupon_id']=$coupon_info['id_coupon'];
			//echo '<pre>';print_r($coupon_info);exit;
			if ($coupon_info) {
				$discount_total = 0;

				if (!$coupon_info['product']) {
					$sub_total = $app->cart->getSubTotal();
				} else {
					$sub_total = 0;

					foreach ($app->cart->getProducts() as $product) {
						if (in_array($product['id_product'], $coupon_info['product'])) {
							$sub_total += $product['total'];
						}
					}					
				}

				if ($coupon_info['type'] == 'F') {
					$coupon_info['discount'] = min($coupon_info['discount'], $sub_total);
				}

				foreach ($app->cart->getProducts() as $product) {
					$discount = 0;

					if (!$coupon_info['product']) {
						$status = true;
					} else {
						if (in_array($product['id_product'], $coupon_info['product'])) {
							$status = true;
						} else {
							$status = false;
						}
					}

					if ($status) {
						if ($coupon_info['type'] == 'F') {
							$discount = $coupon_info['discount'] * ($product['total'] / $sub_total);
						} elseif ($coupon_info['type'] == 'P') {
							$discount = $product['total'] / 100 * $coupon_info['discount'];
						}

						/*if ($product['id_tax_class']) {
							$tax_rates = $app->tax->getRates($product['total'] - ($product['total'] - $discount), $product['id_tax_class']);

							foreach ($tax_rates as $tax_rate) {
								if ($tax_rate['type'] == 'P') {
									$taxes[$tax_rate['tax_rate_id']] -= $tax_rate['amount'];
								}
							}
						}*/
					}

					$discount_total += $discount;
				}

				/*if ($coupon_info['shipping'] && isset($this->session->data['shipping_method'])) {
					if (!empty($this->session->data['shipping_method']['tax_class_id'])) {
						$tax_rates = $this->tax->getRates($this->session->data['shipping_method']['cost'], $this->session->data['shipping_method']['tax_class_id']);

						foreach ($tax_rates as $tax_rate) {
							if ($tax_rate['type'] == 'P') {
								$taxes[$tax_rate['tax_rate_id']] -= $tax_rate['amount'];
							}
						}
					}

					$discount_total += $this->session->data['shipping_method']['cost'];				
				}*/				
				$_SESSION['coupon_amount']=$discount_total;
				$couponInfo=$_SESSION['coupon_code']!=""?"(".$_SESSION['coupon_code'].")":"";
				$cartRule['cartRule'][] = array(
                'code'       => 'COUPON',
                'label'      => 'Coupon '.$couponInfo.': ',
                'text'       => $app->currency->format(-$discount_total),//$this->currency->format(max(0, $cartRule['total'])),
                'value'      => -$discount_total,//max(0, $total),
                'sort_order' => (int)Yii::app()->config->getData('CARTRULE_COUPON_SORT_ORDER')
            );

			$cartRule['total']-=$discount_total;
			} 
		}
	}
    
    /*public function applyRule(&$cartRule) 
    {
        $app=Yii::app();
        $cartRule['cartRule'][] = array(
                'code'       => 'COUPON',
                'label'      => 'Coupon : ',
                'text'       => $app->currency->format($cartRule['total']),//$this->currency->format(max(0, $cartRule['total'])),
                'value'      => $subTotal,//max(0, $total),
                //'sort_order' => $this->config->get('total_sort_order')//not so usefull i think
            );
    }*/


	public function getStatus()
	{
		//echo 'select count(*) as count from {{configuration}} where code="COUPON" and `key`="CARTRULE_COUPON_STATUS" and status="1"';
		//exit;
		$row=Yii::app()->db->createCommand('select count(*) as count from {{configuration}} where code="COUPON" and `key`="CARTRULE_COUPON_STATUS" and value="1"')->queryRow();
		if($row['count'])
		{
			//echo "in status if";
			return true;
		}else
		{
			//echo "in status else";
			return false;
		}
	}


	public function getCoupon($code) {
		$status = true;

		$couponRow = Yii::app()->db->createCommand("SELECT * FROM {{coupon}} WHERE code = '" . $code . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) AND status = '1'")->queryRow();

		if ($couponRow['id_coupon']!="") {
			if ($couponRow['total'] >= Yii::app()->cart->getSubTotal()) {
				$status = false;
			}

			$couponHistoryRow = Yii::app()->db->createCommand("SELECT COUNT(*) AS total FROM {{coupon_history}} ch WHERE ch.id_coupon = '" . (int)$couponRow['id_coupon'] . "'")->queryRow();

			if ($couponRow['uses_total'] > 0 && ($couponHistoryRow['total'] >= $couponRow['uses_total'])) {
				$status = false;
			}
			//exit($couponRow['logged'] ."&&". $_SESSION['user_id']);	
			if ($couponRow['logged'] && $_SESSION['user_id']=='') {
				$status = false;
				Yii::app()->user->setFlash('danger_invalid_coupon', 'You should login to apply coupon!!');
				//exit;
			}

			if ($_SESSION['user_id']!='') {
				$couponHistoryRow = Yii::app()->db->createCommand("SELECT COUNT(*) AS total FROM {{coupon_history}} ch WHERE ch.id_coupon = '" . (int)$couponRow['id_coupon'] . "' AND ch.id_customer = '" . (int)$_SESSION['user_id'] . "'")->queryRow();

				if ($couponRow['uses_customer'] > 0 && ($couponHistoryRow['total'] >= $couponRow['uses_customer'])) {
					$status = false;
				}
			}

			// Products
			$coupon_product_data = array();

			$couponProductRows = Yii::app()->db->createCommand("SELECT * FROM {{coupon_product}} WHERE id_coupon = '" . (int)$couponRow['id_coupon'] . "'")->queryAll();

			foreach ($couponProductRows as $product) {
				$coupon_product_data[] = $product['id_product'];
			}

 			$product_data = array();
			
			if ($coupon_product_data ) {
				foreach (Yii::app()->cart->getProducts() as $product) {
					if (in_array($product['id_product'], $coupon_product_data)) {
						$product_data[] = $product['id_product'];

						continue;
					}
			}	

				if (!$product_data) {
					$status = false;
				}
			}
		} else {
			$status = false;
		}


		if($status)
		{
			return array(
				'id_coupon'     => $couponRow['id_coupon'],
				'code'          => $couponRow['code'],
				'name'          => $couponRow['name'],
				'type'          => $couponRow['type'],
				'discount'      => $couponRow['discount'],
				//'shipping'      => $couponRow['shipping'],
				'total'         => $couponRow['total'],
				'product'       => $product_data,
				'date_start'    => $couponRow['date_start'],
				'date_end'      => $couponRow['date_end'],
				'uses_total'    => $couponRow['uses_total'],
				'uses_customer' => $couponRow['uses_customer'],
				'status'        => $couponRow['status'],
				'date_created'    => $couponRow['date_created']
			);
		}else
		{
			return $status;
		}
		
		/*if ($status) {
			return array(
				'id_coupon'     => $couponRow['id_coupon'],
				'code'          => $couponRow['code'],
				'name'          => $couponRow['name'],
				'type'          => $couponRow['type'],
				'discount'      => $couponRow['discount'],
				'shipping'      => $couponRow['shipping'],
				'total'         => $couponRow['total'],
				'product'       => $product_data,
				'date_start'    => $couponRow['date_start'],
				'date_end'      => $couponRow['date_end'],
				'uses_total'    => $couponRow['uses_total'],
				'uses_customer' => $couponRow['uses_customer'],
				'status'        => $couponRow['status'],
				'date_added'    => $couponRow['date_added']
			);
		}*/
	}
}