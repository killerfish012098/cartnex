<?php

class TaxClassRuleArea extends CActiveRecord
{

	public function tableName()
	{
		return '{{tax_class_rule_area}}';
	}

	public function rules()
	{
		return array(
			array('id_tax_class_rule, id_tax_class, id_country, id_state, priority', 'numerical', 'integerOnly'=>true),
			array('id_tax_class_rule_area, id_tax_class_rule, id_tax_class, id_country, id_state, priority', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
                     'taxclassrule'=>array(self::BELONGS_TO,'TaxClassRule','id_tax_class_rule'),
                    );
	}


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
    public function scopes()
	{
		return array('lang'=>array('condition'=>$this->getTableAlias(false, false).'.id_language='.Yii::app()->session['language']));
    }
}
