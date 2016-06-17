<?php
class ProductImage extends CActiveRecord
{
        public $prev_image;
	public function tableName()
	{
		return '{{product_image}}';
	}

	public function rules()
	{
		return array(
                //array('image', 'file', 'types'=>'jpg'),
                array('id_product, id_product_option_value,sort_order', 'numerical', 'integerOnly'=>true),
                array('id_product,id_product_option_value,html_content,sort_order,image', 'safe'),
            );
	}


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
