<?php
Class Cash_On_Delivery_Class
{
    public $code;
    public $tax;
    public $region;
    public $sort_order;
    public $order_status_id;
    public $status;
    public $title;
    
    public function __construct() 
    {
        $this->code='COD';
    }
    
    public function define()
    {
        $this->tax=Yii::app()->config()->getData('PAYMENT_'.$this->code.'_TAX_CLASS');
        $this->sort_order=Yii::app()->config()->getData('PAYMENT_'.$this->code.'_SORT_ORDER');
        $this->region=Yii::app()->config()->getData('PAYMENT_'.$this->code.'_REGION');
        $this->status=Yii::app()->config()->getData('PAYMENT_'.$this->code.'_STATUS');
        $this->title=Yii::app()->config()->getData('PAYMENT_'.$this->code.'_TITLE');
        $this->order_status_id=Yii::app()->config()->getData('PAYMENT_'.$this->code.'_ORDER_STATUS_ID');
    }
    
    Public function isAllowed()
    {
        //will check some conditions if payment gatewaye is applied or not based on user selection
        return true;
    }
    
    
    public function renderData() //will be called in confirm page
    {

    }
    
    public function beforeOrderProcess() // after order before insertion
    {

    }
    
    public function afterOrderProcess() //after order after insertion
    {

    }

	function setInputFields()
	{
      //global $order;
	  /*
	  //can take credit card details and send to the form address given
	  $order=$_SESSION['order'];
      for ($i=1; $i<13; $i++) {
        $expires_month[] = array('id' => sprintf('%02d', $i), 'text' => strftime('%B',mktime(0,0,0,$i,1,2000)));
      }

      $today = getdate();
      for ($i=$today['year']; $i < $today['year']+10; $i++) {
        $expires_year[] = array('id' => strftime('%y',mktime(0,0,0,1,1,$i)), 'text' => strftime('%Y',mktime(0,0,0,1,1,$i)));
      }

      $confirmation = array('fields' => array(array('title' => MODULE_PAYMENT_AUTHORIZENET_CC_AIM_CREDIT_CARD_OWNER,
                                                    'field' => tep_draw_input_field('cc_owner', $order->billing['firstname'] . ' ' . $order->billing['lastname'])),
                                              array('title' => MODULE_PAYMENT_AUTHORIZENET_CC_AIM_CREDIT_CARD_NUMBER,
                                                    'field' => tep_draw_input_field('cc_number_nh-dns')),
                                              array('title' => MODULE_PAYMENT_AUTHORIZENET_CC_AIM_CREDIT_CARD_EXPIRES,
                                                    'field' => tep_draw_pull_down_menu_payment('cc_expires_month', $expires_month) . '&nbsp;' . tep_draw_pull_down_menu_payment('cc_expires_year', $expires_year)),
                                              array('title' => MODULE_PAYMENT_AUTHORIZENET_CC_AIM_CREDIT_CARD_CVC,
                                                    'field' => tep_draw_input_field('cc_cvc_nh-dns', '', 'size="5" maxlength="4"'))));

      return $confirmation;*/
	  return false;
    }

	function setHiddenData() {
		return false;
     /* //hidden fields to be send to the given form address
	  //global $customer_id, $order, $sendto, $currency, $cart_DirecPay_ID, $shipping;
	 $obj=new Model_OrderTotal_OtVoucher();
	 //print_r($obj->output);
		$adres=$this->getAddress();
		$cartObj=new Model_Cart();
		$custObj=new Model_Customer();
		$taxes=array_sum($cartObj->getTaxes());
		
		$complete_total=$cartObj->getTotal()+$_SESSION['shipping_method']['cost']+$taxes;
		//start voucher reduction
		if(isset($_SESSION['voucher']) && $_SESSION['voucher']!="")
		{
			$vou=$cartObj->getVoucherDiscount($complete_total,$_SESSION['voucher']);
			//echo "value of ".$vou." total ".$complete_total;
			$complete_total=$complete_total-$vou;
		}
		//end voucher reduction

	  $custom_id=$_SESSION['customer_id']!=""?$_SESSION['customer_id']:'0';

	  $process_button_string = '';

	  $parameters['custName'] = $adres['payment']['firstname']." ".$adres['payment']['lastname'] ;
	  $parameters['custAddress'] =  $adres['payment']['address_1'];
	  $parameters['custCity'] = $adres['payment']['city'];
	  $parameters['custState'] =  $adres['payment']['state'];
	  $parameters['custPinCode'] = $adres['payment']['postcode'];
	  $parameters['custCountry'] = $adres['payment']['iso_code_2'];
		
		if($_SESSION['guest']!="")
		{

			$parameters['custEmailId'] = $adres['payment']['email'];
			$parameters['custMobileNo']=$adres['payment']['telephone'];
			$parameters['deliveryMobileNo']=$adres['payment']['telephone'];
		}
		else
		{
			$tele=$custObj->getTelephone();
			$email=$custObj->getEmail();
			$parameters['custEmailId'] = $email;
			$parameters['custMobileNo'] = $tele;
			$parameters['deliveryMobileNo'] = $tele;
		}

	  $parameters['deliveryName'] = $adres['shipping']['firstname'];
	  $parameters['deliveryAddress'] = $adres['shipping']['address_1'];
	  $parameters['deliveryCity'] = $adres['shipping']['city'];
	  $parameters['deliveryState'] = $adres['shipping']['state'];
	  $parameters['deliveryPinCode'] = $adres['shipping']['postcode'];
	  $parameters['deliveryCountry'] = $adres['shipping']['iso_code_2'];
	  $parameters['otherNotes'] = 'Online payment';
	  $parameters['editAllowed'] = 'N';
	  $order_id = substr($cart_DirecPay_ID, strpos($cart_DirecPay_ID, '-')+1);
  	  $parameters['requestparameter'] = MODULE_PAYMENT_DIRECPAY_MERCHANT_ID.'|DOM|'.$adres['payment']['iso_code_3'].'|'.$_SESSION['Curr']['currency'].'|'.$this->format_raw($complete_total).'|'.$_SESSION['order_id'].'|others|'.Model_Url::getLink(array("controller"=>"checkout","action"=>"checkout-process"),'',SERVER_SSL).'|
'.Model_Url::getLink(array("controller"=>"checkout","action"=>"cart"),'',SERVER_SSL).'|'.$this->collaborator.'';
        reset($parameters);
        while (list($key, $value) = each($parameters)) {
          $process_button_string .= tep_draw_hidden_field($key, $value);
        }

      return $process_button_string;
	  */
    }

	public function callback()
	{
		//Yii::app()->order->update();
		//return false;
		//return $message;
	}


}