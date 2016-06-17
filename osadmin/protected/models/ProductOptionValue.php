<?php

class ProductOptionValue extends CActiveRecord
{
	public function tableName()
	{
		return '{{product_option_value}}';
	}

	public function rules()
	{
		return array(
			array('id_product_option, id_product, id_option', 'required'),
			array('id_product_option, id_product, id_option, id_option_value, id_base_option_value, quantity, subtract', 'numerical', 'integerOnly'=>true),
			array('id_product_option_value, id_product_option, id_product, id_option, id_option_value, id_base_option_value, quantity, subtract, price, price_prefix, points, points_prefix, weight, weight_prefix', 'safe'),
		);
	}


	public function attributeLabels()
	{
		return array(
			'id_product_option_value' => 'Id Product Option Value',
			'id_product_option' => 'Id Product Option',
			'id_product' => 'Id Product',
			'id_option' => 'Id Option',
			'id_option_value' => 'Id Option Value',
			'id_base_option_value' => 'Id Base Option Value',
			'quantity' => 'Quantity',
			'subtract' => 'Subtract',
			'price' => 'Price',
			'price_prefix' => 'Price Prefix',
			'points' => 'Points',
			'points_prefix' => 'Points Prefix',
			'weight' => 'Weight',
			'weight_prefix' => 'Weight Prefix',
		);
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
