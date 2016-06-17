<?php

class ProductSpecial extends CActiveRecord
{
	public function tableName()
	{
		return '{{product_special}}';
	}

	public function rules()
	{
		return array(
			array('id_product, id_customer_group,quantity, priority', 'required'),
			array('id_product, id_customer_group, priority,quantity', 'numerical', 'integerOnly'=>true),
			array('price,start_date,end_date', 'safe'),
		);
	}


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
