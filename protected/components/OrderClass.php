<?php

class OrderClass {

    public function init() {
        
    }

	public function create($data) {
		foreach($data as $key=>$val)
		{
			if($val=="")
			{
				$data[$key]="";
			}
		}
		//echo '<pre>';print_r($data);echo '</pre>';exit;
		$command=Yii::app()->db->createCommand("INSERT INTO {{order}} (`id_customer`, `id_customer_group`, `customer_group`, `firstname`, `lastname`, `telephone`,  `email_address`, `message`, `delivery_firstname`, `delivery_lastname`, `delivery_company`, `delivery_address_1`, `delivery_address_2`, `delivery_city`, `delivery_postcode`, `delivery_state`, `id_state_delivery`, `delivery_country`, `id_country_delivery`, `shipping_method`, `shipping_method_code`, `billing_firstname`, `billing_lastname`, `billing_company`, `billing_address_1`, `billing_address_2`, `billing_city`, `billing_postcode`, `billing_state`, `billing_country`, `id_state_billing`, `id_country_billing`, `payment_method`, `payment_method_code`, `date_modified`, `date_created`, `id_order_status`, `order_status_name`, `ip_address`, `total`, `language_code`,`id_language`, `currency`, `currency_value`) VALUES (:id_customer,:id_customer_group,:customer_group,:firstname,:lastname,:telephone,:email_address,:message,:delivery_firstname,:delivery_lastname,:delivery_company,:delivery_address_1,:delivery_address_2,:delivery_city,:delivery_postcode,:delivery_state,:id_state_delivery,:delivery_country,:id_country_delivery,:shipping_method,:shipping_method_code,:billing_firstname,:billing_lastname,:billing_company,:billing_address_1,:billing_address_2,:billing_city,:billing_postcode,:billing_state,:billing_country,:id_state_billing,:id_country_billing,:payment_method,:payment_method_code,:date_modified,:date_created,:id_order_status,:order_status_name,:ip_address,:total,:language_code,:id_language,:currency,:currency_value)");
		$command->bindValue(':id_customer', $data['id_customer']);
		$command->bindValue(':id_customer_group', $data['id_customer_group']);
		$command->bindValue(':customer_group', $data['customer_group']);
		$command->bindValue(':firstname', $data['firstname']);
		$command->bindValue(':lastname', $data['lastname']);
		$command->bindValue(':email_address', $data['email_address']);
		$command->bindValue(':telephone', $data['telephone']);
		$command->bindValue(':message', $data['message']);
		$command->bindValue(':delivery_firstname', $data['delivery_firstname']);
		$command->bindValue(':delivery_lastname', $data['delivery_lastname']);
		$command->bindValue(':delivery_company', $data['delivery_company']);
		$command->bindValue(':delivery_address_1', $data['delivery_address_1'],PDO::PARAM_STR);
		$command->bindValue(':delivery_address_2', $data['delivery_address_2']);
		$command->bindValue(':delivery_city', $data['delivery_city']);
		$command->bindValue(':delivery_postcode', $data['delivery_postcode']);
		$command->bindValue(':delivery_state', $data['delivery_state']);
		$command->bindValue(':id_state_delivery', $data['id_state_delivery']);
		$command->bindValue(':delivery_country', $data['delivery_country']);
		$command->bindValue(':id_country_delivery', $data['id_country_delivery']);
		$command->bindValue(':shipping_method', $data['shipping_method']);
		$command->bindValue(':shipping_method_code', $data['shipping_method_code']);
		$command->bindValue(':billing_firstname', $data['billing_firstname']);
		$command->bindValue(':billing_lastname', $data['billing_lastname']);
		$command->bindValue(':billing_company', $data['billing_company']);
		$command->bindValue(':billing_address_1', $data['billing_address_1']);
		$command->bindValue(':billing_address_2', $data['billing_address_2']);
		$command->bindValue(':billing_city', $data['billing_city']);
		$command->bindValue(':billing_postcode', $data['billing_postcode']);
		$command->bindValue(':billing_state', $data['billing_state']);
		$command->bindValue(':billing_country', $data['billing_country']);
		$command->bindValue(':id_state_billing', $data['id_state_billing']);
		$command->bindValue(':id_country_billing', $data['id_country_billing']);
		$command->bindValue(':payment_method', $data['payment_method']);
		$command->bindValue(':payment_method_code', $data['payment_method_code']);
		$command->bindValue(':date_modified', date('Y-m-d H:i:s'));
		$command->bindValue(':date_created', date('Y-m-d H:i:s'));
		$command->bindValue(':id_order_status', $data['id_order_status']);
		$command->bindValue(':order_status_name', $data['order_status_name']);
		$command->bindValue(':ip_address', $data['ip_address']);
		$command->bindValue(':total', $data['total']);
		$command->bindValue(':language_code', $data['language_code']);
		$command->bindValue(':id_language', $data['id_language']);
		$command->bindValue(':currency', $data['currency']);
		$command->bindValue(':currency_value', $data['currency_value']);
		$command->execute();

		$id_order = Yii::app()->db->getLastInsertId();

		foreach ($data['products'] as $product) {
			$command="";
			$command=Yii::app()->db->createCommand("INSERT INTO {{order_product}} (`id_order`, `id_product`, `model`, `name`, `unit_price`, `total`, `tax`, `quantity`, `has_download`, `download_filename`, `download_mask`, `download_remaining_count`, `download_expiry_date`) VALUES (:id_order,:id_product,:model,:name,:unit_price,:total,:tax,:quantity,:has_download,:download_filename,:download_mask,:download_remaining_count,:download_expiry_date)");
			$command->bindValue(':id_order', $id_order);
			$command->bindValue(':id_product', $product['id_product']);
			$command->bindValue(':model', $product['model']);
			$command->bindValue(':name', $product['name']);
			$command->bindValue(':unit_price', (float)$product['unit_price']);
			$command->bindValue(':total', (float)$product['total']);
			$command->bindValue(':tax', (float)$product['tax']);
			$command->bindValue(':quantity', $product['quantity']);
			$command->bindValue(':has_download', $product['has_download']);
			$command->bindValue(':download_filename', $product['download_filename']);
			$command->bindValue(':download_mask', $product['download_mask']);
			$command->bindValue(':download_remaining_count', $product['download_remaining_count']);
			$command->bindValue(':download_expiry_date', $product['download_expiry_date']);
			$command->execute();
			
			$id_order_product =Yii::app()->db->getLastInsertId();

			foreach ($product['option'] as $option) {
				$command=Yii::app()->db->createCommand("INSERT INTO {{order_product_option}} (`id_order`,`id_order_product`,`id_product_option`,`id_product_option_value`, `name`, `value`, `type`) VALUES (:id_order,:id_order_product,:id_product_option,:id_product_option_value,:name,:value,:type)");
				$command->bindValue(':id_order', (int)$id_order);
				$command->bindValue(':id_order_product', (int)$id_order_product);
				$command->bindValue(':id_product_option', (int)$option['id_product_option']);
				$command->bindValue(':id_product_option_value', (int)$option['id_product_option_value']);
				$command->bindValue(':name', $option['name']);
				$command->bindValue(':value', $option['value']);
				$command->bindValue(':type', $option['type']);
				$sql_result = $command->execute();
			}
		}

		foreach ($data['cartrules'] as $cartrule) {
			
			$command=Yii::app()->db->createCommand("INSERT INTO {{order_total}} (`id_order`, `title`, `text`, `value`, `code`, `sort_order`) VALUES (:id_order,:title,:text,:value,:code,:sort_order)");
			$command->bindValue(':id_order', (int)$id_order);
			$command->bindValue(':title', $cartrule['label']);
			$command->bindValue(':text', $cartrule['text']);
			$command->bindValue(':value', $cartrule['value']);
			$command->bindValue(':code', $cartrule['code']);
			$command->bindValue(':sort_order', $cartrule['sort_order']);
			$sql_result = $command->execute();

		}
		//exit;
		return $id_order;
	}

	public function getOrder($id_order) 
	{
		$row = Yii::app()->db->createCommand("SELECT * FROM {{order}} WHERE id_order = '" . (int)$id_order . "'")->queryRow();
		return $row;
	}

	public function getOrderByCustomer($id_order) 
	{
		$row = Yii::app()->db->createCommand("SELECT * FROM {{order}} WHERE id_customer='".Yii::app()->session['user_id']."' and id_order = '" . (int)$id_order . "'")->queryRow();
		return $row;
	}

	public function confirm($data)
	{

		$order_info = $this->getOrder($data['id_order']);
		
		if (isset($order_info) && !$order_info['id_order_status'])
		//if (1)
		{
			$row = Yii::app()->db->createCommand("SELECT MAX(invoice_no) AS invoice_no FROM {{order}} WHERE invoice_no!='0'")->queryRow();
			
			if ($row['invoice_no']) {
				$invoice_no = (int)$row['invoice_no'] + 1;
			} else {
				$invoice_no = 1;
			}
			
			$posRow=Yii::app()->db->createCommand('select value from {{configuration}} where `key` like "PAYMENT_'.$order_info['payment_method_code'].'_ORDER_STATUS_ID"')->queryRow();
			
			$osRow=Yii::app()->db->createCommand('select name from {{order_status}} where id_order_status="'.$posRow['value'].'" and id_language="'.$order_info['id_language'].'"')->queryRow();
			//echo '<pre>';print_r($posRow);print_r($osRow);exit;
			$update=Yii::app()->db->createCommand()->update('{{order}}',array('id_order_status'=>$posRow['value'],'order_status_name'=>$osRow['name'],'date_modified'=>date('Y-m-d H:i:s'),'invoice_no'=>$invoice_no,'invoice_prefix'=>Yii::app()->config->getData('CONFIG_STORE_INVOICE_PREFIX')),'id_order=:id',array(':id'=>(int)$data['id_order']));
			
			$command=Yii::app()->db->createCommand("INSERT INTO {{order_history}} (`id_order`, `id_order_status`,`order_status_name`, `date_created`,`notified_by_customer`) VALUES (:id_order,:id_order_status,:order_status_name,:date_created,:notified_by_customer)");
			$command->bindValue(':id_order', (int)$data['id_order']);
			$command->bindValue(':id_order_status', $posRow['value']);
			$command->bindValue(':order_status_name', $osRow['name']);
			$command->bindValue(':date_created', date('Y-m-d H:i:s'));
			$command->bindValue(':notified_by_customer','1');
			$sql_result = $command->execute();

			$order_product_rows = Yii::app()->db->createCommand("SELECT * FROM {{order_product}} WHERE id_order = '" . (int)$data['id_order'] . "'")->queryAll();
			
			foreach ($order_product_rows as $order_product) {
				/*$this->db->query("UPDATE r_products SET products_quantity = (products_quantity - " . (int)$order_product['products_quantity'] . ") WHERE products_id = '" . (int)$order_product['products_id'] . "' AND substract_stock = '1'");*/

				$update=Yii::app()->db->createCommand("UPDATE {{product}} SET quantity = (quantity - " . (int)$order_product['quantity'] . ") WHERE id_product = '" . (int)$order_product['id_product'] . "' AND subtract_stock = '1'")->query();
					
				$order_option_rows = Yii::app()->db->createCommand("SELECT * FROM {{order_product_option}} WHERE id_order_product='".(int)$order_product['id_order_product']."' and id_order = '" . (int)$data['id_order'] . "'")->queryAll();

				foreach ($order_option_rows as $option) {
					$update=Yii::app()->db->createCommand("UPDATE {{product_option_value}} SET quantity = (quantity - " . (int)$option['quantity'] . ") WHERE id_product_option_value = '" . (int)$option['id_product_option_value'] . "' AND subtract = '1'")->query();
				}
			}

			//start update coupon
			$this->addCoupon($data);
			//end update coupon

			$order_total_rows = Yii::app()->db->createCommand("SELECT * FROM {{order_total}} WHERE id_order = '".(int)$data['id_order']."'")->queryAll();
			foreach ($order_total_rows as $order_total) {
				//$confVal=Configuration::model()->find('code="'.$order_total['code'].'" and `key` like "CARTRULE_'.$order_total['code'].'_FILE"');
				$order_total_row = Yii::app()->db->createCommand("SELECT * FROM {{configuration}} WHERE code='".$order_total['code']."' and `key` like 'CARTRULE_".$order_total['code']."_FILE'")->queryRow();
				
				Yii::import('application.models.cartrules.'.trim($order_total_row['value']).'_Class');
				$class=trim($order_total_row['value']).'_Class';
				$obj=new $class;
				if (method_exists($obj, 'confirm')) {
					$obj->confirm($order_info, $order_total);
				}
			}

			$cartrules = Yii::app()->db->createCommand("SELECT * FROM {{order_total}} WHERE id_order = '" . (int)$data['id_order'] . "' ORDER BY sort_order ASC")->queryAll();
			//echo '<pre>';print_r($cartrules);echo '</pre>';
			$id_customer = $order_info['id_customer'];
			$link = Yii::app()->createUrl('account/orderdetails',array('id'=>$order_info['id_order']));
			$download=0;
			foreach($order_product_rows as $order_product_row)
			{
				if($order_product_row['has_download'])
				{
					$download=1;	
				}
			}

			//exit("download : ".$download);

			$invoice_no = $order_info['invoice_prefix'].$order_info['invoice_no'];
			$id_order=$order_info['id_order'];
			$date_created = date(Yii::t('common','date_format_short'), strtotime($order_info['date_created']));
			$payment_method = $order_info['payment_method'];
			$shipping_method = $order_info['shipping_method'];
			$email = $order_info['email_address'];
			$telephone = $order_info['telephone'];
			$ip = $order_info['ip_address'];

			$payment_address=$order_info['billing_firstname'].',<br/>'.$order_info['billing_lastname'].',<br/>'.$order_info['billing_company'].',<br/>'.$order_info['billing_address_1'].',<br/>'.$order_info['billing_address_2'].',<br/>'.$order_info['billing_city'].',<br/>'.$order_info['billing_state'].',<br/>'.$order_info['billing_postcode'].',<br/>'.$order_info['billing_country'];
			
			if($shipping_method)
			{
				$shipping_address=$order_info['shipping_firstname'].',<br/>'.$order_info['shipping_lastname'].',<br/>'.$order_info['shipping_company'].',<br/>'.$order_info['shipping_address_1'].',<br/>'.$order_info['shipping_address_2'].',<br/>'.$order_info['shipping_city'].',<br/>'.$order_info['shipping_state'].',<br/>'.$order_info['shipping_postcode'].',<br/>'.$order_info['shipping_country'];
			}
			$products = array();
			$order_product_rows = Yii::app()->db->createCommand("SELECT * FROM {{order_product}} WHERE id_order = '" . (int)$id_order . "'")->queryAll();
			foreach ($order_product_rows as $product) {
				$option_data = array();

				$order_option_rows = Yii::app()->db->createCommand("SELECT * FROM {{order_product_option}} WHERE id_order = '" . (int)$id_order . "' AND id_order_product = '" . (int)$product['id_order_product'] . "'")->queryAll();
				foreach ($order_option_rows as $option) {
					if ($option['type'] != 'file') {
						$option_data[] = array(
							'name'  => $option['name'],
							'value' => (strlen($option['value']) > 20 ? substr($option['value'], 0, 20) . '..' : $option['value'])
						);
					} else {
						$filename = substr($option['value'], 0, strrpos($option['value'], '.'));

						$option_data[] = array(
							'name'  => $option['name'],
							'value' => (strlen($filename) > 20 ? substr($filename, 0, 20) . '..' : $filename)
						);
					}
				}
				//echo "<br/> unit price ".$product['unit_price']." currency ".$order_info['currency']." total ".$product['total']." currency value ".$order_info['currency_value'];
				$products[] = array(
					'name'     => $product['name'],
					'model'    => $product['model'],
					'option'   => $option_data,
					'quantity' => $product['quantity'],
					'price'    => Yii::app()->currency->format($product['unit_price'], $order_info['currency'], $order_info['currency_value']),
					'total'    =>Yii::app()->currency->format($product['total'], $order_info['currency'], $order_info['currency_value'])

				);
			}
			//echo '<pre>';print_r($products);echo '</pre>';exit;
			 
			//Library::preCheckMailTemplate(array('id_language'=>$order_info['id_language'],'code'=>$order_info['language_code']));
			ob_start();
			include 'uploads/order_'.$order_info["language_code"].'.tpl';
			$description = ob_get_contents();
			ob_end_clean();
			//echo '<pre>';print_r($products);
			//echo $description;
			//exit('before');
			

			$email_template_row=Yii::app()->db->createCommand("SELECT * FROM {{email_template_description}} WHERE id_email_template = '1' and id_language='".$order_info["id_language"]."'")->queryRow();
			
			$data=array('subject'=>$email_template_row['subject'],'description'=>$description,'replace'=>array('%username%'=>$admin['first_name'].$admin['last_name']),'mail'=>array("to"=>array($order_info['email_address']=>$order_info['firstname'].' '.$order_info['lastname'])));
			if(Yii::app()->config->getData('CONFIG_STORE_ORDER_ALERT_MAILS')!='')
			{
				$exp=explode(',',Yii::app()->config->getData('CONFIG_STORE_ORDER_ALERT_MAILS'));
				foreach($exp as $expEmail)
				{
					//$bcc[$expEmail]=;
					$data["mail"]["bcc"][$expEmail]=Yii::app()->config->getData('CONFIG_STORE_NAME');
				}
				
			}
			
			//echo '<pre>';print_r($data);echo '</pre>';exit;
			Mail::send($data);
		}
		//exit('at last');
	}



	public function update($id_order, $id_order_status, $message = '', $notify = false) {
		$order_info = $this->getOrder($id_order);

		if ($order_info && $order_info['id_order_status']) {
			
			$osRow=Yii::app()->db->createCommand('select name from {{order_status}} where id_order_status="'.$id_order_status.'" and id_language="'.$order_info['id_language'].'"')->queryRow();		
			$update=Yii::app()->db->createCommand()->update('{{order}}',array('order_status_name'=>'','id_order_status'=>$id_order_status,'date_modified'=>date('Y-m-d H:i:s')),'id_order=:id',array(':id'=>(int)$id_order));
			
			$command=Yii::app()->db->createCommand("INSERT INTO {{order_history}} (`id_order`, `id_order_status`,`order_status_name`, `notified_by_customer`, `message`, `date_created`) VALUES ('id_order,:id_order_status,:order_status_name,:notified_by_customer,:message,:date_created')");
			
			$command->bindValue(':id_order', $id_order);
			$command->bindValue(':id_order_status', $id_order_status);
			$command->bindValue(':message', $message);
			$command->bindValue(':notified_by_customer', (int)$notify);
			$command->bindValue(':order_status_name',$osRow['name']);
			$command->bindValue(':date_created', date('Y-m-d H:i:s'));
			$sql_result = $command->execute();
			

 			if ($notify) {
				/*$language = new Language($order_info['language_directory']);
				$language->load($order_info['language_filename']);
				$language->load('mail/order');

				$subject = sprintf($language->get('text_update_subject'), html_entity_decode($order_info['store_name'], ENT_QUOTES, 'UTF-8'), $order_id);

				$message  = $language->get('text_update_order') . ' ' . $order_id . "\n";
				$message .= $language->get('text_update_date_added') . ' ' . date($language->get('date_format_short'), strtotime($order_info['date_added'])) . "\n\n";

				$order_status_query = $this->db->query("SELECT * FROM r_order_status WHERE order_status_id = '" . (int)$order_status_id . "' AND language_id = '" . (int)$order_info['language_id'] . "'");

				if ($order_status_query->num_rows) {
					$message .= $language->get('text_update_order_status') . "\n\n";
					$message .= $order_status_query->row['name'] . "\n\n";
				}

				if ($order_info['customer_id']) {
					$message .= $language->get('text_update_link') . "\n";
					$message .= $order_info['store_url'] . 'account/orderinfo/order_id/' . $order_id . "\n\n";
				}

				if ($comment) {
					$message .= $language->get('text_update_comment') . "\n\n";
					$message .= $comment . "\n\n";
				}

				$message .= $language->get('text_update_footer');

				$mail = new Mail();
				$mail->protocol = $this->config->get('config_mail_protocol');
				$mail->parameter = $this->config->get('config_mail_parameter');
				$mail->hostname = $this->config->get('config_smtp_host');
				$mail->username = $this->config->get('config_smtp_username');
				$mail->password = $this->config->get('config_smtp_password');
				$mail->port = $this->config->get('config_smtp_port');
				$mail->timeout = $this->config->get('config_smtp_timeout');
				$mail->setTo($order_info['email']);
				$mail->setFrom($this->config->get('config_email'));
				$mail->setSender($order_info['store_name']);
				$mail->setSubject($subject);
				$mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
				$mail->send();*/
			}
		}
	}
	
	public function getCustomerOrders($id_customer)
	{
		$rows=Yii::app()->db->createCommand('select * from {{order}} where id_customer="'.$id_customer.'" and invoice_no!=0 and id_order_status!=0')->queryAll();
		$arrayDataProvider=new CArrayDataProvider($rows, array(
		'pagination'=>array(
			'pageSize'=>10,
		),
		'sort' => array(
                'defaultOrder' => 'date_created DESC',
            ),	
		));
		return $arrayDataProvider;
	}

	public function getCustomerOrderHistory($id_order)
	{
		return Yii::app()->db->createCommand("select * from {{order_history}} where id_order='".(int)$id_order."' and notified_by_customer=1 order by date_created desc")->queryAll();
	}

	public function getOrderProducts($id)
	{
		$products=Yii::app()->db->createCommand("select *,date(download_expiry_date) as download_expiry_date from {{order_product}} where id_order='".$id."'")->queryAll();
		$data=array();
		foreach ($products as $product) {
            
			$options=array();
			$options=Yii::app()->db->createCommand("select * from {{order_product_option}} where id_order='".$id."' and id_order_product='".$product['id_order_product']."'")->queryAll();
			
			foreach ($options as $option) {
                $product['options'][] = array(
                    "id_product_option" => $option['id_product_option'],
                    "id_product_option_value" => $option['id_product_option_value'],
                    "name" => $option['name'],
                    "value" => $option['value'],
                    "type" => $option['type']
                );
            }

            //$data['product'][$product['id_order_product']]['unit_price'] = $product['unit_price'];
            //$data['product'][$product['id_order_product']]['total'] = $product['total'];

            /*if ($product['has_download']):
                $data['download'][$product['id_order_product']]['download_filename'] = $product['download_filename'];
                $data['download'][$product['id_order_product']]['download_mask'] = $product['download_mask'];
                $data['download'][$product['id_order_product']]['download_remaining_count'] = $product['download_remaining_count'];
                $data['download'][$product['id_order_product']]['download_expiry_date'] = $product['download_expiry_date'];
            endif;*/
			$data[]=$product;
		}
		//echo '<pre>';print_r($data);echo '</pre>';exit;
		return $data;
	}

	public function getOrderTotals($id)
	{
		return Yii::app()->db->createCommand("select * from {{order_total}} where id_order='".$id."' order by sort_order asc")->queryAll();
	}

	public function getOrderedProductById($id)
	{
		return Yii::app()->db->createCommand("select o.*,op.has_download,op.download_filename,op.download_mask,op.download_remaining_count,date(op.download_expiry_date) as download_expiry_date from {{order}} o ,{{order_product}} op where o.id_order=op.id_order and  id_order_product='".$id."'")->queryRow();
	}

	public function updateProductDownloadRemaining($opid)
	{
		Yii::app()->db->createCommand("update {{order_product}} set download_remaining_count=download_remaining_count-1 where id_order_product='".$opid."'")->query();
	}

	public function addCoupon($data)
	{
		if(!empty($_SESSION['coupon_code'])){
			Yii::app()->db->createCommand()->insert('{{coupon_history}}',array('id_coupon'=>(int)$_SESSION['coupon_id'],'id_order'=>(int)$data['id_order'],'id_customer'=>(int)$_SESSION['user_id'],'amount'=>$_SESSION['coupon_amount'],'date_created'=>date('Y-m-d H:i:s')));
		}
	}
}