<?php
class OptionValue extends CActiveRecord
{
        public $name;
        public $sort_order;
        public function tableName()
	{
		return '{{option_value}}';
	}

	public function rules()
	{
		return array(
			array('sort_order,id_option', 'numerical', 'integerOnly'=>true),
		);
	}


        public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
