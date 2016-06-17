<?php
class Cash_On_Delivery_Model extends CFormModel
{
	public $PAYMENT_COD_TITLE;
	public $PAYMENT_COD_SORT_ORDER;
	public $PAYMENT_COD_ORDER_STATUS_ID;
	public $PAYMENT_COD_REGION;
    public $PAYMENT_COD_STATUS;

	public function rules()
	{
		return array(
			array('PAYMENT_COD_TITLE, PAYMENT_COD_SORT_ORDER, PAYMENT_COD_ORDER_STATUS_ID,PAYMENT_COD_STATUS', 'required'),
			array('PAYMENT_COD_REGION','safe'),
			);
	}

	public function attributeLabels()
	{
		return 
			array('PAYMENT_COD_TITLE'=>Yii::t('payment','entry_title'),
			'PAYMENT_COD_ORDER_STATUS_ID'=>Yii::t('payment','entry_order_status'),
			'PAYMENT_COD_STATUS'=>Yii::t('payment','entry_status'),
			'PAYMENT_COD_REGION'=>Yii::t('payment','entry_region'),
			'PAYMENT_COD_SORT_ORDER'=>Yii::t('payment','entry_sort_order'));
	}

	 
	
	public function getCode()
	{
		return 'COD';
	}

}