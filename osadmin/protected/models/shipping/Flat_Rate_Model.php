<?php
class Flat_Rate_Model extends CFormModel
{
	public $SHIPPING_FLAT_TITLE;
	public $SHIPPING_FLAT_COST;
	public $SHIPPING_FLAT_TAX_CLASS;
	public $SHIPPING_FLAT_REGION;
    public $SHIPPING_FLAT_STATUS;
	public $SHIPPING_FLAT_SORT_ORDER;
	public $SHIPPING_FLAT_FILE;

	public function rules()
	{
		return array(
			array('SHIPPING_FLAT_TITLE,SHIPPING_FLAT_STATUS,SHIPPING_FLAT_COST,SHIPPING_FLAT_SORT_ORDER','required'),
			array('SHIPPING_FLAT_TAX_CLASS,SHIPPING_FLAT_REGION','safe'),
			);
	}

	public function attributeLabels()
	{
		return array('SHIPPING_FLAT_TITLE'=>Yii::t('shipping','entry_title'),
					'SHIPPING_FLAT_STATUS'=>Yii::t('shipping','entry_status'),
					'SHIPPING_FLAT_COST'=>Yii::t('shipping','entry_cost'),
					'SHIPPING_FLAT_SORT_ORDER'=>Yii::t('shipping','entry_sort_order'),
					'SHIPPING_FLAT_REGION'=>Yii::t('shipping','entry_region'),
					'SHIPPING_FLAT_TAX_CLASS'=>Yii::t('shipping','entry_tax'),	
		);
	}

	public function getCode()
	{
		return 'FLAT';
	}
}