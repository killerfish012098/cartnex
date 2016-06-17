<?php

class BannerImage extends CActiveRecord
{

	public function tableName()
	{
		return '{{banner_image}}';
	}

	public function rules()
	{
		return array(
			array('id_banner, link, image', 'required'),
			array('id_banner', 'numerical', 'integerOnly'=>true),
			array('link, image', 'length', 'max'=>255),
			array('id_banner_image, id_banner, link, image', 'safe', 'on'=>'search'),
		);
	}

	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
