<?php

class CategoryFilter extends CActiveRecord
{

	public function tableName()
	{
		return '{{category_filter}}';
	}


	public function rules()
	{

		return array(
			array('id_category, id, type, sort_order', 'required'),
			array('id_category, id, sort_order', 'numerical', 'integerOnly'=>true),
			array('type', 'length', 'max'=>10),
			array('id_category_filter, id_category, id, type, sort_order', 'safe', 'on'=>'search'),
		);
	}


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
