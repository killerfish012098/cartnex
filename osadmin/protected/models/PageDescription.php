<?php
class PageDescription extends CActiveRecord
{
	public function tableName()
	{
		return '{{page_description}}';
	}

	public function rules()
	{
		return array(
            array('title,description','required'),
			array('id_page, id_language', 'numerical', 'integerOnly'=>true),
			array('title, meta_title', 'length', 'max'=>150),
			array('meta_keywords, meta_description', 'length', 'max'=>255),
			array('description', 'safe'),
			array('id_page_description, id_page, title, description, meta_title, meta_keywords, meta_description, id_language', 'safe', 'on'=>'search'),
		);
	}


	public function attributeLabels()
	{
		return array(
	
			'title' => Library::flag().Yii::t('pages','entry_title'),
			'description' => Library::flag().Yii::t('pages','entry_description'),
			'meta_title' => Library::flag().Yii::t('pages','entry_meta_title'),
			'meta_keywords' => Library::flag().Yii::t('pages','entry_meta_keywords'),
			'meta_description' => Library::flag().Yii::t('pages','entry_meta_description'),
		);
	}


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
