<?php

class TaxClassRuleDescription extends CActiveRecord
{
	public function tableName()
	{
		return '{{tax_class_rule_description}}';
	}

	public function rules()
	{
		
		return array(
            array('name','required'),
			array('id_tax_class_rule, id_language', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>32),
			array('id_tax_class, id_tax_class_rule, id_language, name', 'safe', 'on'=>'search'),
		);
	}

	
	public function relations()
	{
		
		return array(
                     'taxClassRule'=>array(self::HAS_ONE,'TaxClassRule','id_tax_class_rule'),
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
