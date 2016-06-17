<?php
class CodModel extends CFormModel
{
	public $PAYMENT_COD_TITLE;
	public $PAYMENT_COD_SORT_ORDER;
	public $PAYMENT_COD_ORDER_STATUS_ID;
	public $PAYMENT_COD_REGION;
    public $PAYMENT_COD_STATUS;

	public function rules()
	{
		return array(
			//array('PAYMENT_COD_TITLE, PAYMENT_COD_SORT_ORDER, PAYMENT_COD_ORDER_STATUS_ID, PAYMENT_COD_REGION,PAYMENT_COD_STATUS', 'required'),
		array('PAYMENT_COD_TITLE, PAYMENT_COD_SORT_ORDER, PAYMENT_COD_ORDER_STATUS, PAYMENT_COD_REGION,PAYMENT_COD_STATUS', 'required'),
			);
	}

	public function init()
	{
            $this->PAYMENT_COD_TITLE="Cash On Delivery";
            $this->PAYMENT_COD_SORT_ORDER="1";
            $this->PAYMENT_COD_ORDER_STATUS_ID="4";
            $this->PAYMENT_COD_REGION="4";
            $this->PAYMENT_COD_STATUS="1";
	}

	public function attributeLabels()
	{
		return array(
			//'verifyCode'=>'Verification Code',
		);
	}

	public function getTitle()
	{
		return $this->"PAYMENT_".$this->getCode()."_TITLE";
	}

	public function getSortOrder()
	{
		return return $this->"PAYMENT_".$this->getCode()."_SORT_ORDER";
	}
	
	public function getCode()
	{
		return 'COD';
	}

}