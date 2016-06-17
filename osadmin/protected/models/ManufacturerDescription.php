<?php

class ManufacturerDescription extends CActiveRecord
{

        public function tableName()
	{
		return '{{manufacturer_description}}';
	}

	public function rules()
	{
		return array(
			array('name', 'required'),
			array('id_manufacturer, id_language', 'numerical', 'integerOnly'=>true),
			array('name, meta_title, meta_keywords, meta_description', 'length', 'max'=>100),
			array('id_manufacturer_description, id_manufacturer, name, meta_title, meta_keywords, meta_description, id_language', 'safe', 'on'=>'search'),
            array('name','safe'),
		);
	}


	public function attributeLabels()
	{
		return array(
			
			'name' => Library::flag().Yii::t('manufacturers','entry_name'),
			'meta_title' => Library::flag().Yii::t('manufacturers','entry_meta_title'),
			'meta_keywords' => Library::flag().Yii::t('manufacturers','entry_meta_keywords'),
			'meta_description' => Library::flag().Yii::t('manufacturers','entry_meta_description'),
			);
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
