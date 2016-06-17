<?php

class ProductGroupDescription extends CActiveRecord
{
	public function tableName()
	{
		return '{{product_group_description}}';
	}

	public function rules()
	{
			return array(
			array('lable','required'),
			array('id_product_group, id_language', 'numerical', 'integerOnly'=>true),
			array('lable', 'length', 'max'=>100),
			array('id_product_group, id_language, lable', 'safe', 'on'=>'search'),
		);
	}


	public function attributeLabels()
	{
		return array(
			'lable' => Library::flag().Yii::t('productgroups','entry_lable'),
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
