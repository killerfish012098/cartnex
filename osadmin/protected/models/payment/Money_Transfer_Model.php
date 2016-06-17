<?php
class Money_Transfer_Model extends CFormModel
{
	public $PAYMENT_MT_TITLE;
	public $PAYMENT_MT_SORT_ORDER;
	public $PAYMENT_MT_ORDER_STATUS_ID;
	public $PAYMENT_MT_REGION;
    public $PAYMENT_MT_STATUS;

	public function rules()
	{
		return array(
			array('PAYMENT_MT_TITLE, PAYMENT_MT_SORT_ORDER, PAYMENT_MT_ORDER_STATUS_ID, PAYMENT_MT_REGION,PAYMENT_MT_STATUS', 'required'),
			);
	}

	 

	public function attributeLabels()
	{
		return array(
			//'verifyCode'=>'Verification Code',
		);
	}

	 
	public function getCode()
	{
		return 'MT';
	}

}