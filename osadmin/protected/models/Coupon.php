<?php
class Coupon extends CActiveRecord
{

	public $date_start=null;
	public $date_end=null;
	public function tableName()
	{
		return '{{coupon}}';
	}

	public function rules()
	{
		return array(
			array('name, code', 'required'),
			array('logged,  uses_total, status', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>128),
			array('code', 'length', 'max'=>10),
			array('type', 'safe'),
			array('discount, total', 'length', 'max'=>15,),
			array('uses_customer', 'length', 'max'=>11),
			array('date_start, date_end, date_created', 'safe'),
			array('status','default','value'=>1,'setOnEmpty'=>true,'on'=>'insert'),
			array('date_start,date_end','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>true,'on'=>'insert'),
			array('date_created','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>true,'on'=>'insert'),
			array('status','default','value'=>1,'setOnEmpty'=>true,'on'=>'insert'),
            array('date_modified','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'update'),
            array('date_created,date_modified','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'insert'),
			array('id_coupon, name, code, type, discount, logged,  total, date_start, date_end, uses_total, uses_customer, status, date_created, date_modified', 'safe', 'on'=>'search'),
		);
	}


	public function attributeLabels()
	{
		return array(
		
		    'name' => yii::t('coupons','entry_name'),
			'code' => yii::t('coupons','entry_code'),
			'type' => yii::t('coupons','entry_type'),
			'discount' => yii::t('coupons','entry_discount'),
			'logged' => yii::t('coupons','entry_logged'),

			'total' => yii::t('coupons','entry_total'),
			'date_start' => yii::t('coupons','entry_date_start'),
			'date_end' => yii::t('coupons','entry_date_end'),
			'uses_total' =>yii::t('coupons','entry_uses_total'),
			'uses_customer' => yii::t('coupons','entry_uses_customer'),
			'status' => yii::t('coupons','entry_status'),
			'date_created' => yii::t('coupons','entry_date_created'),
			'date_modified' => yii::t('coupons','entry_date_modified'),
	
		);
	}
        
        public function search() {
			$criteria = new CDbCriteria;
			$criteria->compare('LOWER(name)',strtolower($this->name),true, 'AND', 'ILIKE'); 
			$criteria->compare('LOWER(code)',strtolower($this->code),true, 'AND', 'ILIKE');
			$criteria->compare('date(date_start)',$this->date_start);
			$criteria->compare('date(date_end)',$this->date_end);
			$criteria->compare('status',$this->status);
			$criteria->compare('discount',$this->discount,true);
			//$criteria->order='id_coupon desc';
			return new CActiveDataProvider($this,
				array(
					'criteria' => $criteria,
					'pagination' => array(
					'pageSize' =>Yii::app()->config->getData('CONFIG_WEBSITE_ITEMS_PER_PAGE_ADMIN'),
					),
					'sort' => array(
					'defaultOrder' => 'id_coupon DESC',
					),
				));
        }


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
