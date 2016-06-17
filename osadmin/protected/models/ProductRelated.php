<?php


class RProductRelated extends CActiveRecord
{

	public function tableName()
	{
		return '{{product_related}}';
	}


	public function rules()
	{

		return array(
			array('id_product, id_related', 'required'),
			array('id_product, id_related', 'numerical', 'integerOnly'=>true),
			array('id_product, id_related', 'safe', 'on'=>'search'),
		);
	}



	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
