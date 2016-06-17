<?php

class CouponHistory extends CActiveRecord
{
	public function tableName()
	{
		return '{{coupon_history}}';
	}

	public function rules()
	{
		return array(
			array('id_coupon, id_order, id_customer, amount, date_created', 'required'),
			array('id_coupon, id_order, id_customer', 'numerical', 'integerOnly'=>true),
			array('amount', 'length', 'max'=>15),
			array('id_coupon_history, id_coupon, id_order, id_customer, amount, date_created', 'safe', 'on'=>'search'),
		);
	}


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
