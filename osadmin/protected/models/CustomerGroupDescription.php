<?php

class CustomerGroupDescription extends CActiveRecord
{
	public function tableName()
	{
		return '{{customer_group_description}}';
	}

	public function rules()
	{
		return array(
            array('name', 'required'),
			array('name', 'length', 'max'=>64),
		);
	}

	public function attributeLabels()
	{
		return array(
			'name' => Library::flag().Yii::t('customergroups','entry_name'),
		);
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function scopes(){
			return array('lang'=>array('condition'=>$this->getTableAlias(false, false).'.id_language='.Yii::app()->session['language']), );
        }
}
