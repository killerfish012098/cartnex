<?php
class ProductCategory extends CActiveRecord
{
    public function tableName()
	{
		return '{{product_category}}';
	}

	public function rules()
	{
		return array(
            array('id_product,id_category', 'numerical', 'integerOnly'=>true),
		);
	}
		public function attributeLabels()
	{
		return array(
			'id_category'=>Yii::t('products','entry_category')	,
		);
	}
	
    public function beforeSave()
    {
        return $this->id_category==0?false:true;
    }
        
    public function primaryKey()
    {
        return array('id_product','id_category');    
    }

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
    public function getProductCategories($id)
    {
        return ProductCategory::model()->findAll('id_product='.$id);
    }
}
