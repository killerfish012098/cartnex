<?php
class Table_Rate_Model extends CFormModel
{
	public $SHIPPING_TABLE_TITLE;
	public $SHIPPING_TABLE_COST;
	public $SHIPPING_TABLE_TAX_CLASS;
	public $SHIPPING_TABLE_REGION;
    public $SHIPPING_TABLE_STATUS;
	public $SHIPPING_TABLE_SORT_ORDER;
	public $SHIPPING_TABLE_FILE;

	public function rules()
	{
		return array(
			array('SHIPPING_TABLE_TITLE,SHIPPING_TABLE_STATUS,SHIPPING_TABLE_COST,SHIPPING_TABLE_TAX_CLASS,SHIPPING_TABLE_REGION,SHIPPING_TABLE_SORT_ORDER','required'),
			);
	}

	public function attributeLabels()
	{
		return 
			array('SHIPPING_TABLE_TITLE'=>Yii::t('shipping','entry_title'),
			'SHIPPING_TABLE_STATUS'=>Yii::t('shipping','entry_status'),
			'SHIPPING_TABLE_COST'=>Yii::t('shipping','entry_cost'),
			'SHIPPING_TABLE_TAX_CLASS'=>Yii::t('shipping','entry_tax'),
			'SHIPPING_TABLE_REGION'=>Yii::t('shipping','entry_region'),
			'SHIPPING_TABLE_SORT_ORDER'=>Yii::t('shipping','entry_sort_order'));
	}

	public function getCode()
	{
		return 'TABLE';
	}
}