<?php

class Review extends CActiveRecord
{
	public $product_name;
	public function tableName()
	{
		return '{{product_review}}';
	}
	public function rules()
	{
		return array(
			array('id_product,customer_name,text,rating', 'required'),
			array('id_review, id_product, id_customer,rating, status', 'numerical', 'integerOnly'=>true),
			array('customer_name,text', 'length', 'max'=>250),
			array('date_created','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'insert'),
            array('date_modified','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'update'),
            array('date_created,date_modified','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'insert'),
			array('product_name,customer_name,rating,status,date_created', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'product'=>array(self::BELONGS_TO,'ProductDescription','id_product'),
		);
	}
	
        public function attributeLabels()
	{
		return array(
			'id_product' => Yii::t('reviews','entry_product'),
			'customer_name' => Yii::t('reviews','entry_customer_name'),
			'text' => Yii::t('reviews','entry_text'),
			'rating' => Yii::t('reviews','entry_rating'),
			'date_created' => Yii::t('reviews','entry_date_created'),
			'date_modified' => Yii::t('reviews','entry_date_modified'),
			'status' => Yii::t('reviews','entry_status'),
			'read' => Yii::t('reviews','entry_read'),
		);
	}

    public function search()
	{
		$criteria=new CDbCriteria;
		$criteria->with=array('product');
		$criteria->compare('product.name',$this->product_name);
		$criteria->compare('product.id_language',Yii::app()->session['language']);
		$criteria->compare('customer_name',$this->customer_name,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('rating',$this->rating,true);
		$criteria->compare('status',$this->status);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
                'pageSize' =>Yii::app()->config->getData('CONFIG_WEBSITE_ITEMS_PER_PAGE_ADMIN'),
            ),
			'sort' => array(
                'defaultOrder' => 'id_review DESC',
            ),
		));
		
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
