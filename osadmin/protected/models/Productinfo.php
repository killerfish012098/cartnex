<?php

class Productinfo extends CActiveRecord
{
	public $pageSize;
	public function tableName()
	{
		return '{{productinfo}}';
	}

	public function rules()
	{
		return array(
			array('name, price, model, date_added, status, quantity', 'required'),
			array('status, quantity', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>100),
			array('price', 'length', 'max'=>10),
			array('model', 'length', 'max'=>20),
			array('id, name, price, model, date_added, status, quantity', 'safe', 'on'=>'search'),
		);
	}


	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'price' => 'Price',
			'model' => 'Model',
			'date_added' => 'Date Added',
			'status' => 'Status',
			'quantity' => 'Quantity',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;
		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('model',$this->model,true);
		$criteria->compare('date_added',$this->date_added,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('quantity',$this->quantity);

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
        
        public function primaryKey(){
            return array('id_product','id_language');
        }
}
