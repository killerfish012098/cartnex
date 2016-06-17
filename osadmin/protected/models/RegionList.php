<?php

class RegionList extends CActiveRecord
{
	public function tableName()
	{
		return '{{region_list}}';
	}

	public function rules()
	{
		return array(
			array('id_region, id_country, id_state', 'numerical', 'integerOnly'=>true),
			array('id_region_list, id_region, id_country, id_state', 'safe', 'on'=>'search'),
		);
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
