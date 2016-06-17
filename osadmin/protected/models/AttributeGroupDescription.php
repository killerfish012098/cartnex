<?php

class AttributeGroupDescription extends CActiveRecord
{
	public $filter;
	public function tableName()
	{
		return '{{attribute_group_description}}';
	}

	
	public function rules()
	{
		return array(
                        array('name','required'),
			array('id_attribute_group, id_language', 'numerical', 'integerOnly'=>true),
			array(', id_attribute_group, id_language, name', 'safe', 'on'=>'search'),
		);
	}


	public function relations()
	{
	        return array(
                    'attributegroup'=>array(self::HAS_ONE,'AttributeGroup','id_attribute_group'),
		);
	}

	public function attributeLabels()
	{
		return array(  
			'name'=> Library::flag().Yii::t('attributes','entry_group_name')
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
