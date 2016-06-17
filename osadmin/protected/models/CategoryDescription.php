<?php

class CategoryDescription extends CActiveRecord
{
	public function tableName()
	{
		return '{{category_description}}';
	}

	public function rules()
	{
		return array(
            array('name','required'),
			array('id_category, id_language', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>32),
			array('meta_title,meta_keyword, meta_description', 'length', 'max'=>500),
			array('description', 'safe'),
			array('id_category_description,id_category, id_language, name, meta_title, meta_keyword, meta_description, description', 'safe', 'on'=>'search'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'name' => Library::flag().Yii::t('categories','entry_name'),
			'meta_title' => Library::flag().Yii::t('categories','entry_meta_title'),
			'meta_keyword' => Library::flag().Yii::t('categories','entry_meta_keyword'),
			'meta_description' => Library::flag().Yii::t('categories','entry_meta_description'),
			'description' => Library::flag().Yii::t('categories','entry_description'),
			);
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
