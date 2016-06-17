<?php

class ProductAttribute extends CActiveRecord
{
        public $name;
        public function tableName()
	{
		return '{{product_attribute}}';
	}

	public function rules()
	{
            return array(
                    array('id_language,id_attribute,id_product,text','required'),
                 );
	}
	
    public function scopes(){
        return array(
            'lang'=>array('condition'=>'id_language='.Yii::app()->session['language']),
        );
    }
        
    public function primaryKey()
    {
        return array('id_product','id_attribute','id_language');
    }
        
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
