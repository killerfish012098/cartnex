<?php

class ProductGroupList extends CActiveRecord
{
    public $id_product;
    public $name;
	public function tableName()
	{
		return '{{product_group_list}}';
	}

	public function rules()
	{
		
		return array(
			array('id_product_group, id_product', 'numerical', 'integerOnly'=>true),
			array('id_product_group, id_product', 'safe', 'on'=>'search'),
		);
	}

	
	public function relations()
	{
		return array('product'=>array(self::BELONGS_TO,'ProductDescription','id_product'));
	}

	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function getProductGroupList($id)
        {
            $criteria = new CDbCriteria;
            $criteria->select="pd.name as name,pd.id_product as id_product";
            $criteria->join="INNER JOIN {{product_description}} as pd ON(pd.id_product=t.id_product)";
            $criteria->condition='pd.id_language="'.Yii::app()->session['language'].'" and  t.id_product_group='.$id;
            $model=ProductGroupList::model()->findAll($criteria);
            return $model;
        }
}
