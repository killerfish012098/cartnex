<?php
class ProductDescription extends CActiveRecord
{
	public function tableName()
	{
		return '{{product_description}}';
	}

	public function rules()
	{
		return array(
			array('name', 'required'),
			array('id_language', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>64),
			array('meta_keywords', 'length', 'max'=>255),
			array('meta_description', 'length', 'max'=>500),
			array('description', 'safe'),
			array('name', 'safe', 'on'=>'search'),
		);
	}


	public function attributeLabels()
	{
		return array(
			'name' => Library::flag().Yii::t('products','entry_name'),
			'meta_keywords' => Library::flag().Yii::t('products','entry_meta_keywords'),
			'meta_description' => Library::flag().Yii::t('products','entry_meta_description'),
			'description' => Library::flag().Yii::t('products','entry_description'),
		);
	}

	/*public function defaultScope()
	{
            return array('condition'=>$this->getTableAlias(false, false).'.id_language='.Yii::app()->session['language']);
        }*/
        
        public function scopes()
        {
           return array(
               'lang'=>array('condition'=>$this->getTableAlias(false, false).'.id_language='.Yii::app()->session['language']),
               );
        }
        
        public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
