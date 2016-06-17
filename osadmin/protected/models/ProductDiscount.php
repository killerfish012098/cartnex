<?php


class RProductDiscount extends CActiveRecord
{

	public function tableName()
	{
		return '{{product_discount}}';
	}


	public function rules()
	{
		return array(
			array('id_product, id_customer_group', 'required'),
			array('id_product, id_customer_group, quantity, priority', 'numerical', 'integerOnly'=>true),
			array('price', 'length', 'max'=>15),
			array('date_start, date_end', 'safe'),
			array('id_product_discount, id_product, id_customer_group, quantity, priority, price, date_start, date_end', 'safe', 'on'=>'search'),
		);
	}



	public function attributeLabels()
	{
		return array(
			'id_product_discount' => 'Id Product Discount',
			'id_product' => 'Id Product',
			'id_customer_group' => 'Id Customer Group',
			'quantity' => 'Quantity',
			'priority' => 'Priority',
			'price' => 'Price',
			'date_start' => 'Date Start',
			'date_end' => 'Date End',
		);
	}


	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id_product_discount',$this->id_product_discount);
		$criteria->compare('id_product',$this->id_product);
		$criteria->compare('id_customer_group',$this->id_customer_group);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('priority',$this->priority);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('date_start',$this->date_start,true);
		$criteria->compare('date_end',$this->date_end,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
                'pageSize' =>Yii::app()->config->getData('CONFIG_WEBSITE_ITEMS_PER_PAGE_ADMIN'),
            ),
		));
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
