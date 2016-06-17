<?php


class RProductTag extends CActiveRecord
{

	public function tableName()
	{
		return '{{product_tag}}';
	}

	public function rules()
	{
		return array(
			array('id_product, tag, id_language', 'required'),
			array('id_product, id_language', 'numerical', 'integerOnly'=>true),
			array('tag', 'length', 'max'=>32),
			array('id_product_tag, id_product, tag, id_language', 'safe', 'on'=>'search'),
		);
	}


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
