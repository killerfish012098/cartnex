<?php

class Country extends CActiveRecord
{
	public $zone_search;

	public function tableName()
	{
		return '{{country}}';
	}

	public function rules()
	{
		return array(
			array('id_zone,name,call_prefix', 'required'),
			array('id_zone, call_prefix, status', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>64),
			array('address_format', 'length', 'max'=>250),
			array('iso_code_2, iso_code_3', 'length', 'max'=>3),
			array('status','default','value'=>1,'setOnEmpty'=>true,'on'=>'insert'),
			array('id_country, id_zone, name, call_prefix, zone_search,address_format, iso_code_2, iso_code_3, status', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'zone'=>array(self::HAS_ONE,'Zone','id_zone'),
		);
	}
	
        public function attributeLabels()
	{
		return array(
			'name' => Yii::t('countries','entry_name'),
			'status' => Yii::t('countries','entry_status'),
			'id_zone' => Yii::t('countries','entry_zone'),
			'call_prefix' => Yii::t('countries','entry_call_prefix'),
			'address_format' => Yii::t('countries','entry_address_format'),
			'iso_code_2' => Yii::t('countries','entry_iso_code_2'),
			'iso_code_3' => Yii::t('countries','entry_iso_code_3'),
			'status' => Yii::t('countries','entry_status'),
		);
	}


        
    public function search()
	{

		$criteria=new CDbCriteria;
		$criteria->with=array('zone');
		$criteria->compare('zone.name',$this->zone_search,true);
		$criteria->compare('t.name',$this->name,true);
		$criteria->compare('iso_code_2',$this->iso_code_2,true);
		$criteria->compare('iso_code_3',$this->iso_code_3,true);
		$criteria->compare('t.status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array(
            'pageSize' =>Yii::app()->config->getData('CONFIG_WEBSITE_ITEMS_PER_PAGE_ADMIN'),
            ),
			'sort' => array(
                'defaultOrder' => 'id_country DESC',
				),
		));
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getCountries()
	{
		return Country::model()->findAll();
	}
}
