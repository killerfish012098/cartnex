<?php

class OrderHistory extends CActiveRecord
{
	
	public function tableName()
	{
		return '{{order_history}}';
	}

	public function rules()
	{
		return array(
			array('id_order, order_status_name, date_created', 'required'),
			array('id_order_status,id_order,  notified_by_customer', 'numerical', 'integerOnly'=>true),
			array('message', 'safe'),
			
		);
	}


	public function attributeLabels()
	{
		return array(
			'id_order_history' => 'Id Order Status History',
			'id_order' => 'Id Order',
			'id_order_status' => 'Id Order Status',
			'date_added' => 'Date Added',
			'customer_notified' => 'Customer Notified',
			'comments' => 'Comments',
		);
	}

	

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getOrderHistory($condition)
	{
	 	return OrderHistory::model()->findAll($condition);
	}

}
