<?php

class OrderProductOption extends CActiveRecord
{
	
	public function tableName()
	{
		return '{{order_product_option}}';
	}

	
	public function rules()
	{
		
		return array(
			array('id_order, id_order_product, id_product_option, name, value, type', 'required'),
			array('id_order, id_order_product, id_product_option, id_product_option_value', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			array('type', 'length', 'max'=>32),
			array('id_order_option, id_order, id_order_product, id_product_option, id_product_option_value, name, value, type', 'safe', 'on'=>'search'),
		);
	}


	public function relations()
	{
		
		return array(	);
	}


	public function attributeLabels()
	{
		return array(
			'id_order_option' => 'Id Order Option',
			'id_order' => 'Id Order',
			'id_order_product' => 'Id Order Product',
			'id_product_option' => 'Id Product Option',
			'id_product_option_value' => 'Id Product Option Value',
			'name' => 'Name',
			'value' => 'Value',
			'type' => 'Type',
		);
	}

	
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id_order_option',$this->id_order_option);
		$criteria->compare('id_order',$this->id_order);
		$criteria->compare('id_order_product',$this->id_order_product);
		$criteria->compare('id_product_option',$this->id_product_option);
		$criteria->compare('id_product_option_value',$this->id_product_option_value);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('value',$this->value,true);
		$criteria->compare('type',$this->type,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
                'pageSize' =>Yii::app()->config->getData('CONFIG_WEBSITE_ITEMS_PER_PAGE_ADMIN'),
            ),
			'sort' => array(
                'defaultOrder' => 'id_order_option DESC',
			),
		));
	}

	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
