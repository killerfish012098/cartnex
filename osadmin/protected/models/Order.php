<?php
class Order extends CActiveRecord
{
	public $customer_group;
	public $email;
	public $status;
	public $orders;
	public $products;
	public $customer;
    public $color;
	public $product_name;
	public $date_from;
	public $date_to;
	public $id_product;  
	public $quantity;
	
	public function tableName()
	{
		return '{{order}}';
	}


	public function rules()
	{
		
		return array(
		
	
				array('date_from','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>true,'on'=>'insert'),

				array('invoice_no, invoice_prefix, id_customer, id_customer_group, customer_name, customer_telephone,  customer_email_address, customer_address_format_id, comments, delivery_name, delivery_street_address, delivery_city, delivery_postcode, delivery_country, id_delivery_country, id_delivery_address_format, shipping_method, billing_name, billing_street_address, billing_city, billing_postcode, billing_country, id_billing_country, id_billing_address_format, payment_method, orders_status, ip_address, total, rewards, id_language, delivery_zone, id_delivery_zone, billing_zone, id_billing_zone, id_affiliate, commission, id_currency', 'required'),
				array('id_invoice, id_customer, id_customer_group, customer_address_format_id, id_delivery_country, id_billing_country, orders_status, rewards, id_language, id_delivery_zone, id_billing_zone, id_affiliate, id_currency', 'numerical', 'integerOnly'=>true),
				array('invoice_prefix, commission', 'length', 'max'=>10),
				array('customer_name, customer_telephone, customer_email_address, delivery_name, delivery_company, delivery_street_address, delivery_suburb, delivery_city, delivery_postcode, delivery_state, delivery_country, billing_name, billing_company, billing_street_address, billing_suburb, billing_city, billing_postcode, billing_country, payment_method, cc_owner', 'length', 'max'=>255),
 
				array('shipping_method, billing_zone', 'length', 'max'=>100),
				array('cc_type, ip_address, total', 'length', 'max'=>20),
				array('cc_expires', 'length', 'max'=>4),
				array('delivery_zone', 'length', 'max'=>200),
				array('currency', 'length', 'max'=>3),
				array('currency_value', 'length', 'max'=>14),
				array('date_modified, date_purchased, orders_date_finished', 'safe'),
				
				array('id_order, id_invoice,date_created, invoice_prefix, id_customer, id_customer_group, customer_name, customer_telephone, customer_email_address, customer_address_format_id, comments, delivery_name, delivery_company, delivery_street_address, delivery_suburb, delivery_city, delivery_postcode, delivery_state, delivery_country, id_delivery_country, id_delivery_address_format, shipping_method, billing_name, billing_company, billing_street_address, billing_suburb, billing_city, billing_postcode, billing_country, id_billing_country, id_billing_address_format, payment_method, cc_type, cc_owner, cc_number, cc_expires, date_modified, date_purchased, orders_status, orders_date_finished, ip_address, total, rewards, id_language, delivery_zone, id_delivery_zone, billing_zone, id_billing_zone, id_affiliate, commission, id_currency, currency, currency_value', 'safe', 'on'=>'search'),

				array('product_name, date_from, date_to', 'safe','on'=>'productReport'),
         );
	}



	
	public function attributeLabels()
	{
		return array(
		
		    'id_invoice'     	=> Yii::t('orders','entry_id_invoice'),
			'invoice_prefix' 	=>Yii::t('orders','entry_invoice_prefix'),
			'id_customer_group' 			=>Yii::t('orders','entry_customer_group'),
			'message' 			=>Yii::t('orders','entry_message'),
			'firstname' 	=>Yii::t('orders','entry_firstname'),
			'lastname' 	=>Yii::t('orders','entry_lastname'),
			'delivery_firstname' 	=>Yii::t('orders','entry_firstname'),
			'delivery_lastname' 	=>Yii::t('orders','entry_lastname'),
			'delivery_company' 	=>Yii::t('orders','entry_company'),
			'delivery_address_1' =>Yii::t('orders','entry_address_1'),
			'delivery_address_2' =>Yii::t('orders','entry_address_2'),
			'delivery_city' 	=>Yii::t('orders','entry_city'),
			'delivery_postcode' =>Yii::t('orders','entry_postcode'),
			'delivery_state' 	=>Yii::t('orders','entry_state'),
			'delivery_country' 	=>Yii::t('orders','entry_country'),
			'shipping_method' 	=>Yii::t('orders','entry_shipping_method'),
			'billing_firstname' 		=>Yii::t('orders','entry_firstname'),
			'billing_lastname' 		=>Yii::t('orders','entry_lastname'),
			'billing_company' 	=>Yii::t('orders','entry_company'),
			'billing_address_1' =>Yii::t('orders','entry_address_1'),
			'billing_address_2' =>Yii::t('orders','entry_address_2'),
			'billing_city' 		=>Yii::t('orders','entry_city'),
				'billing_state' 		=>Yii::t('orders','entry_state'),
			'billing_postcode' 	=>Yii::t('orders','entry_postcode'),
			'billing_country' 	=>Yii::t('orders','entry_country'),
			'payment_method' 	=>Yii::t('orders','entry_payment_method'),
			'date_modified' 	=>Yii::t('orders','entry_date_modified'),
			'date_created' 	=>Yii::t('orders','entry_date_created'),
			'orders_status' 	=>Yii::t('orders','entry_orders_status'),
			'orders_date_finished' =>Yii::t('orders','entry_orders_date_finished'),
			'ip_address' 		=>Yii::t('orders','entry_ip_address'),
			'total' 			=>Yii::t('orders','entry_total'),
			'id_language' 		=>Yii::t('orders','entry_id_language'),
			'id_currency' 		=>Yii::t('orders','entry_id_currency'),
			'currency' 			=>Yii::t('orders','entry_currency'),
			'currency_value' 	=>Yii::t('orders','entry_currency_value'),	
		);
	}

	public function search()
	{
            
		$criteria=new CDbCriteria;
		$criteria->select = "t.*,os.color";
		//$criteria->compare('id_order',$this->id_order);
		$criteria->compare('firstname',$this->firstname,true);
        $criteria->compare('id_order_status',$this->id_order_status,true);
		$criteria->compare('date(date_created)',$this->date_created,true);
		$criteria->compare('total',$this->total,true);
		$criteria->join = "LEFT JOIN {{order_status}} as os ON(t.id_order_status=os.id_order_status)";
		$criteria->condition ='invoice_no!=0 and t.id_order_status!=0  and os.id_language="'.Yii::app()->session['language'].'"'; 
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
                'pageSize' =>Yii::app()->config->getData('CONFIG_WEBSITE_ITEMS_PER_PAGE_ADMIN'),
            ),
			'sort' => array(
					'defaultOrder' => 'id_order DESC',
					),
		));
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function getOrderedProducts($id,$order)
        {
            $product=array();
            foreach (OrderProduct::model()->findAll() as $product)
            {
                $product[]['name']=$product->name;
                $product[]['id_product']=$product->id_product;
                $product[]['model']=$product->model;
                $product[]['unit_price']=$product->unit_price;
                $product[]['total']=$product->total;
                $product[]['tax']=$product->tax;
                $product[]['quantity']=$product->quantity;
                $product[]['has_download']=$product->has_download;
                $product[]['download_filename']=$product->download_filename;
                $product[]['download_mask']=$product->download_mask;
                $product[]['download_remaining_count']=$product->download_remaining_count;
                $product[]['download_expiry_date']=$product->download_expiry_date;
            }
            return $product;
        }
        
        public function customerOrderTotalReport()
        {
		
            $string="";
            if(!empty($this->date_from) && !empty($this->date_to))
					{
						$string.=' and date(o.date_created) between "'.$this->date_from.'" and "'.$this->date_to.'"';
					}elseif(!empty($this->date_from) && empty($this->date_to))
					{
						$string.=' and date(o.date_created)>="'.$this->date_from.'"';
					}elseif(empty($this->date_from) && !empty($this->date_to))
					{
						$string.=' and date(o.date_created)<="'.$this->date_to.'"';
					}
					
            $record = Yii::app()->db->createCommand()
                    ->select('tmp.id_customer, concat(tmp.firstname," ",tmp.lastname) as customer, tmp.email, tmp.customer_group, COUNT(tmp.id_order) AS orders, SUM(tmp.products) '
                            . 'AS products,SUM(tmp.total) AS total')
                    ->from('(SELECT o.id_order, o.id_customer, o.firstname AS firstname, o.lastname AS lastname, o.email_address as email, o.customer_group, (SELECT SUM(op.quantity) '
                            . 'FROM {{order_product}} op WHERE op.id_order = o.id_order GROUP BY op.id_order) AS products, o.total FROM {{order}} o where o.id_order_status >0 '.$string.' )  tmp')
					->group('tmp.id_customer,tmp.email')
                    ->order('total DESC');

					

					/*
							$criteria->addBetweenCondition("date(t.date_created)",$this->date_from,$this->date_to,'and');
		echo  "<pre>";
		echo $this->date_from.$this->date_to;
		exit;*/
            $dataReader=$record->query();
            $count=$dataReader->rowCount;		           
             return new CSqlDataProvider($record, 
                     array( 
                    'totalItemCount' => $count,
                    'pagination' => array(
                        'pageSize' => Yii::app()->params['config_page_size'],
                    ),
                ));
         }
         
        public function customerOrderTotalReports()
        {
		
		
        	$criteria=new CDbCriteria;
			$criteria->compare('concat(t.firstname," ",t.lastname)',$this->customer);
			$criteria->select='concat(t.firstname," ",t.lastname) as customer,t.customer_group,t.email_address as email,count(t.id_order) as orders,sum(t.total) as total';
                //$criteria->join="INNER JOIN {{order_product}} op ON (op.id_order=t.id_order)";
                $criteria->condition = 't.id_order_status >0';
                
                $criteria->group='t.id_customer,t.email_address';
                
                /*echo '<pre>';
                print_r(new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
                'pageSize'=>Yii::app()->params['config_page_size'],
            ),
		)));
                echo '</pre>';
                exit;*/
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
                'pageSize'=>Yii::app()->params['config_page_size'],
            ),
			'sort' => array(
					'defaultOrder' => 't.total DESC',
			),
		));
	
        }
        
        public function productReport()
		{
	
		    $criteria=new CDbCriteria;
			 
			$criteria->select='sum( op.total ) AS total, t.email_address, concat( t.firstname, " ", t.lastname ) AS customer, sum( op.quantity ) AS quantity, count( t.id_order ) AS orders'; 
			//modified by fareed t.total to op.total
           $criteria->join="INNER JOIN {{order_product}} op ON (op.id_order=t.id_order)";
			$criteria->addCondition("t.invoice_no!=0 and op.id_product='".(int)$this->product_name."'");
			//exit("value of ".$this->product_name);
			
			//$criteria->addCondition('op.id_product',empty($this->product_name)?'0':$this->product_name);
			
			if(!empty($this->date_from) && !empty($this->date_to)){
					$criteria->addBetweenCondition("date(t.date_created)",$this->date_from,$this->date_to,'and');
				}elseif(!empty($this->date_from) && empty($this->date_to)){
					//echo "at middle";
					$criteria->addCondition('date(t.date_created)>="'.$this->date_from.'"');
				}elseif(empty($this->date_from) && !empty($this->date_to)){
					//echo "at last";
					$criteria->addCondition('date(t.date_created)<="'.$this->date_to.'"');
				}
				
				
				
                //$criteria->order='t.total desc';
                //$criteria->compare('op.id_product',empty($this->product_name)?'0':$this->product_name);
				
				$criteria->group='t.email_address';
                return new CActiveDataProvider($this, array( 'criteria'=>$criteria,
                        'pagination'=>array(
							'pageSize' =>Yii::app()->config->getData('CONFIG_WEBSITE_ITEMS_PER_PAGE_ADMIN'),
						),
					'sort' => array(
					'defaultOrder' => 't.total DESC',
					),
				));
		}


		public function getOrderInfo($input)
		{
			$criteria=new CDbCriteria;

			switch($input['data'])
			{
				case 'OrdersToday': $criteria->select="count('*') as total";
									$criteria->condition='date(date_created)="'.date(Y)."-".date(m)."-".date(d).'" and id_order_status>0';
									$model=Order::model()->find($criteria);
									$return=$model->total;
								break;
							
				case 'TotalOrders':
									$criteria->select="count('*') as total";
									$criteria->condition='id_order_status>0';
									$model=Order::model()->find($criteria);
									$return=$model->total;
								break;
				
				case 'TotalRevenue':
									$criteria->select="sum(total) as total";
									$criteria->condition='id_order_status>0';
									$model=Order::model()->find($criteria);    
									$return=Yii::app()->currency->format($model->total,Yii::app()->config->getData('CONFIG_STORE_DEFAULT_CURRENCY'));
								break;
							
				case 'CurrentYearRevenue':
									$criteria->select="sum(total) as total";
									$criteria->condition='year(date_created)="'.date(Y).'" and id_order_status>0';
									$model=Order::model()->find($criteria);
									$return=Yii::app()->currency->format($model->total,Yii::app()->config->getData('CONFIG_STORE_DEFAULT_CURRENCY'));
								break;
				
				case 'OrdersByStatus':
								$criteria=new CDbCriteria;
								$criteria->select='COUNT( o.id_order ) AS total, os.name AS order_status_name';
								$criteria->alias='o';
								$criteria->join="INNER JOIN {{order_status}} os ON o.id_order_status = os.id_order_status";
								$criteria->condition='o.id_order_status >0 AND os.id_language ="'.Yii::app()->session['language'].'"';
								$criteria->group='o.id_order_status';
								$criteria->order='o.id_order DESC';
								$return=Order::model()->findAll($criteria);
								break;

				case 'ProductOrdersTotal':
								/*echo $this->id_product.'<pre>';
								print_r($input);
								exit('product id'.$input['input']['id_product']);*/
								$criteria=new CDbCriteria;
								$criteria->select='COUNT( o.id_order ) AS total'; 
								$criteria->alias='o';
								$criteria->join='LEFT JOIN {{order_product}} op ON o.id_order = op.id_order';
								$criteria->addCondition('o.id_order_status >0');
								$criteria->compare('op.id_product',empty($input['input']['id_product'])?'0':$input['input']['id_product']);
								if(!empty($input['input']['date_from']) && !empty($input['input']['date_to']))
								{
									$criteria->addBetweenCondition("date(o.date_created)",$input['input']['date_from'],$input['input']['date_to'],'and');
								}elseif(!empty($input['input']['date_from']) && empty($input['input']['date_to']))
								{
									$criteria->addCondition('date(o.date_created)>="'.$input['input']['date_from'].'"');
								}
								elseif(empty($input['input']['date_from']) && !empty($input['input']['date_to']))
								{
									$criteria->addCondition('date(o.date_created)<="'.$input['input']['date_to'].'"');
								}
								$model=Order::model()->find($criteria);
								$return=$model->total;
								break;

				case 'ProductQuantitySold':
								$criteria=new CDbCriteria;
								$criteria->select='sum( op.quantity ) AS	quantity'; 
								$criteria->alias='o';
								$criteria->join='LEFT JOIN {{order_product}} op ON o.id_order = op.id_order';
								$criteria->addCondition('o.id_order_status >0');
								$criteria->compare('op.id_product',empty($input['input']['id_product'])?'0':$input['input']['id_product']);
								if(!empty($input['input']['date_from']) && !empty($input['input']['date_to']))
								{
									$criteria->addBetweenCondition("date(o.date_created)",$input['input']['date_from'],$input['input']['date_to'],'and');
								}elseif(!empty($input['input']['date_from']) && empty($input['input']['date_to']))
								{
									$criteria->addCondition('date(o.date_created)>="'.$input['input']['date_from'].'"');
								}
								elseif(empty($input['input']['date_from']) && !empty($input['input']['date_to']))
								{
									$criteria->addCondition('date(o.date_created)<="'.$input['input']['date_to'].'"');
								}
								$model=Order::model()->find($criteria);
								$return=$model->quantity;
								break;

				case 'ProductOrderedCustomers':
								
								$criteria=new CDbCriteria;
								$criteria->select='count(distinct(email_address)) AS	quantity'; 
								$criteria->alias='o';
								$criteria->join='LEFT JOIN {{order_product}} op ON o.id_order = op.id_order';
								$criteria->addCondition('o.id_order_status >0');
								$criteria->compare('op.id_product',empty($input['input']['id_product'])?'0':$input['input']['id_product']);
								if(!empty($input['input']['date_from']) && !empty($input['input']['date_to']))
								{
									$criteria->addBetweenCondition("date(o.date_created)",$input['input']['date_from'],$input['input']['date_to'],'and');
								}elseif(!empty($input['input']['date_from']) && empty($input['input']['date_to']))
								{
									$criteria->addCondition('date(o.date_created)>="'.$input['input']['date_from'].'"');
								}
								elseif(empty($input['input']['date_from']) && !empty($input['input']['date_to']))
								{
									$criteria->addCondition('date(o.date_created)<="'.$input['input']['date_to'].'"');
								}
								$model=Order::model()->find($criteria);
								$return=$model->quantity;
								break;

				case 'ProductRevenue':
					
								$criteria=new CDbCriteria;
								//$criteria->select='sum(o.total) as total'; 
								$criteria->select='sum(op.total) as total'; 
								$criteria->alias='o';
								$criteria->join='LEFT JOIN {{order_product}} op ON o.id_order = op.id_order';
								$criteria->addCondition('o.id_order_status >0');
								$criteria->compare('op.id_product',empty($input['input']['id_product'])?'0':$input['input']['id_product']);
								if(!empty($input['input']['date_from']) && !empty($input['input']['date_to']))
								{
									$criteria->addBetweenCondition("date(o.date_created)",$input['input']['date_from'],$input['input']['date_to'],'and');
								}elseif(!empty($input['input']['date_from']) && empty($input['input']['date_to']))
								{
									$criteria->addCondition('date(o.date_created)>="'.$input['input']['date_from'].'"');
								}
								elseif(empty($input['input']['date_from']) && !empty($input['input']['date_to']))
								{
									$criteria->addCondition('date(o.date_created)<="'.$input['input']['date_to'].'"');
								}
								$model=Order::model()->find($criteria);
								$return=Yii::app()->currency->format($model->total,Yii::app()->config->getData('CONFIG_STORE_DEFAULT_CURRENCY'));
								break;

			}
			return $return;
		}
		
		public function getOrderChartInfo($input)
		{
		$criteria=new CDbCriteria;
		$range=$input['range']==""?'year':$input['range'];
		switch ($range) {
			case 'day':
                            $date = date('Y') . '-' . date('m') . '-' . date('d');
				for ($i = 0; $i < 24; $i++) {
					$query = Yii::app()->db->createCommand("SELECT COUNT(*) AS total FROM {{order}} WHERE id_order_status > '0' AND (DATE(date_created) =  '".$date."' AND HOUR(date_created) = '" . (int)$i . "') GROUP BY HOUR(date_created) ORDER BY date_created ASC");
					$total=$query->queryScalar();
                    if ($total!="") {
						$data[$i] = $total;
					} else {
						$data[$i] = 0;
					}
				}
                                /*                                echo '<pre>';
                                print_r($data);
                                exit;*/

				break;
			case 'week':
				$date_start = strtotime('-' . date('w') . ' days');
                                $week=array('0'=>'Sun','1'=>'Mon','2'=>'Tue','3'=>'Wed','4'=>'Thu','5'=>'Fri','6'=>'Sat');
				for ($i = 0; $i < 7; $i++) {
					$date = date('Y-m-d', $date_start + ($i * 86400));
					
					$query = Yii::app()->db->createCommand("SELECT COUNT(*) AS total FROM {{order}} WHERE id_order_status > '0' AND DATE(date_created) = '" . $date. "' GROUP BY DATE(date_created)");
					$total=$query->queryScalar();

					 if ($total!="") {
						$data[$week[$i]] = $total;
					} else {
						$data[$week[$i]] = 0;
					}
				}
                                break;    
            		case 'month':
				for ($i = 1; $i <= date('t'); $i++) {
					$date = date('Y') . '-' . date('m') . '-' . $i;
					$query = Yii::app()->db->createCommand("SELECT COUNT(*) AS total FROM {{order}} WHERE id_order_status > '0' AND (DATE(date_created) = '" .$date. "') GROUP BY DAY(date_created)");
					$total=$query->queryScalar();
                                if ($total!="") {
						$data[$i] = $total;
					} else {
						$data[$i] = 0;
					}
				}
                                
				break;
			case 'year':
                                $calender=array('1'=>'Jan','2'=>'Feb','3'=>'Mar','4'=>'Apr','5'=>'may','6'=>'Jun','7'=>'Jul','8'=>'Aug','9'=>'Sep','10'=>'Oct','11'=>'Nov','12'=>'Dec');
				for ($i = 1; $i <= 12; $i++) 
                                {
                                    $query = Yii::app()->db->createCommand("SELECT COUNT(*) AS total FROM {{order}} WHERE id_order_status > '0' AND YEAR(date_created) = '" . date('Y') . "' AND MONTH(date_created) = '" . $i . "' GROUP BY MONTH(date_created)");
                                    $total=$query->queryScalar();
                                    
                                    if ($total!='') 
                                    {
                                        $data[$calender[$i]] =(int)$total;
                                    } else 
                                    {
                                            $data[$calender[$i]] = 0;
                                    }
				}

				break;
		}
                return $data;
		}


		public function bestCustomers()
		{
	
			$criteria=new CDbCriteria;
			$criteria->select='CONCAT( firstname," ", lastname ) AS customer, email_address, telephone, SUM( total ) AS total, COUNT( id_order ) AS id_order';
			$criteria->condition='id_order_status >0';
			
			$criteria->group='email_address';
				
			return new CActiveDataProvider($this, array( 'criteria'=>$criteria,
					'pagination'=>array('pageSize'=>10,
					),
                            'sort' => array(
					'defaultOrder' => 'total DESC',
					),
			));

		}
		
		public function OrdersByStatus()
		{


			$criteria=new CDbCriteria;
			$criteria->select='COUNT( o.id_order ) AS total, os.name AS name';
			$criteria->alias='o';
			$criteria->join="INNER JOIN {{order_status}} os ON o.id_order_status = os.id_order_status";
			$criteria->condition='o.id_order_status >0 AND os.id_language ="'.Yii::app()->session['language'].'"';
			$criteria->group='o.id_order_status';
			$criteria->order='o.id_order DESC';
				
			return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
			'pageSize'=>'10',//Yii::app()->params['config_page_size'],
			),
		));
		}
}
