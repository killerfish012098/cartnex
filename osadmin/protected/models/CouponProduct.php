<?php
class CouponProduct extends CActiveRecord
{
	public function tableName()
	{
		return '{{coupon_product}}';
	}

	public function rules()
	{
		return array(
			array('id_coupon, id_product', 'required'),
			array('id_coupon, id_product', 'numerical', 'integerOnly'=>true),
			array('id_coupon_product, id_coupon, id_product', 'safe', 'on'=>'search'),
		);
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getProductCouponList($id)
    {
        $criteria = new CDbCriteria;
        $criteria->select="pd.name as name,pd.id_product as id_product";
        $criteria->join="INNER JOIN {{product_description}} as pd ON(pd.id_product=t.id_product)";
        $criteria->condition='pd.id_language="'.Yii::app()->session['language'].'" and  t.id_coupon='.$id;
        $model=CouponProduct::model()->findAll($criteria);
        return $model;
    }
}
