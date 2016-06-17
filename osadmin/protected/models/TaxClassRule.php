<?php

class TaxClassRule extends CActiveRecord
{
	public $lable; 
    public $rate; 
    public $type;
    public $based_on;
	public function tableName()
	{
		return '{{tax_class_rule}}';
	}

	public function rules()
	{
		
		return array(
			array('id_tax_class', 'numerical', 'integerOnly'=>true),
			array('rate', 'length', 'max'=>32),
			array('type, based_on', 'length', 'max'=>100),
			array('id_tax_class_rule, id_tax_class, lable,rate, type, based_on', 'safe', 'on'=>'search'),
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
