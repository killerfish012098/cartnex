<?php

class AttributeDescription extends CActiveRecord
{
 	public function tableName()
	{
		return '{{attribute_description}}';
	}

	public function rules()
	{
 		return array(
                        array('name','required'),
			array('id_attribute, id_language', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>64),
			array('id_attribute_description, id_attribute, id_language, name', 'safe', 'on'=>'search'),
		);
	}
        
	public function relations()
	{
        return array(
            'attribute'=>array(self::BELONGS_TO,'Attribute','id_attribute'),
        );
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function scopes(){
           return array(
               'lang'=>array('condition'=>$this->getTableAlias(false, false).'.id_language='.Yii::app()->session['language']),
               );
        }
}