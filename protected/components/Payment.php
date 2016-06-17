<?php

class Payment {

    public function init() {
        
    }

    public function getMethods() {

        //$rows = ConfigurationGroup::model()->findAll('type="PAYMENT"');
		$rows = Yii::app()->db->createCommand("select * from {{configuration_group}} where `type` = 'PAYMENT'")->queryAll();
        $data = array();
        foreach ($rows as $row) {
            //$methods = Configuration::model()->findAll('code="' . $row['code'] . '"');
			$methods = Yii::app()->db->createCommand("select * from {{configuration}} where `code` = '". $row['code'] ."'")->queryAll();
            foreach ($methods as $method) {
                //$data[$method->code][$method->attributes['key']] = $method->attributes['value'];
				$data[$method['code']][$method['key']] = $method['value'];
            }
        }

        $gateway = array();
        foreach ($data as $k => $v) {
            if ($v['PAYMENT_' . $k . '_STATUS'] == 1) {
                $model = $v['PAYMENT_' . $k . '_FILE'] . '_Class';
                Yii::import('application.models.payment.' . $model);
                $obj = new $model;
                if ($obj->isAllowed()) {
                    $gateway['code'][$k] = array('code' => $k, 'title' => $v['PAYMENT_' . $k . '_TITLE'],
                        'key' => $v['PAYMENT_' . $k . '_FILE']);
                    $gateway['sort_order'][] = $v['PAYMENT_' . $k . '_SORT_ORDER'];
                }
            }
        }

        array_multisort($gateway['sort_order'], SORT_ASC, $gateway['code']);

        /*

          echo '<pre>';
          print_r(array(
          array('code' => 'Cod',
          'title' => 'Cash On Delivery',
          ),
          array('code' => 'Direcpay',
          'title' => 'Credit Card | Debit Card | Internet Banking',
          )
          ));
          print_r($data);
          print_r($gateway);

          exit;
          array(
          array('code' => 'Cod',
          'title' => 'Cash On Delivery',
          ),
          array('code' => 'Direcpay',
          'title' => 'Credit Card | Debit Card | Internet Banking',
          )
          );
          //Configuration::model()->
          //load active models from db  & isAllowed function
          //call getQuote method from respective models
          //return array of methods
         */

        return $gateway['code'];
    }

	public function getMethod($payment)
	{
		//$row = Configuration::model()->find('code="' . $payment . '" and `key` like "PAYMENT_'.$payment.'_TITLE"');
		$row = Yii::app()->db->createCommand("select * from {{configuration}} where code = '".$payment."' and `key` like 'PAYMENT_".$payment."_TITLE'")->queryRow();
		/*echo '<pre>';print_r(array('id'=>$payment,
					'module'=>$row->value,
					));exit;*/
		return array('id'=>$payment,
					'module'=>$row['value'],
					);
	}

 	public function getAdditionalParams()
	{
		$return=array();
		//$row = Configuration::model()->find('code="' . $_SESSION['payment_method']['id'] . '" and `key` like "PAYMENT_'.$_SESSION['payment_method']['id'].'_FILE"');
		$row = Yii::app()->db->createCommand("select * from {{configuration}} where code = '".$_SESSION['payment_method']['id']."' and `key` like 'PAYMENT_".$_SESSION['payment_method']['id']."_FILE'")->queryRow();
		
		$model = $row['value'] . '_Class';
		Yii::import('application.models.payment.' . $model);
		$obj = new $model;
		if($obj->isAllowed()) 
		{
			$return['inputFields']=$obj->setInputFields();
			$return['hiddenData']=$obj->setHiddenData();
			$return['action']=$obj->form_action_url!=""?$obj->form_action_url:Yii::app()->createAbsoluteUrl('checkout/checkoutprocess');

		}else
		{
			$return['inputFields']=false;
			$return['hiddenData']=false;
		}
		return $return;
	}

	public function beforeOrderProcess()
	{
		//$row = Configuration::model()->find('code="' . $_SESSION['payment_method']['id'] . '" and `key` like "PAYMENT_'.$_SESSION['payment_method']['id'].'_FILE"');

		$row = Yii::app()->db->createCommand("select * from {{configuration}} where code = '".$_SESSION['payment_method']['id']."' and `key` like 'PAYMENT_".$_SESSION['payment_method']['id']."_FILE'")->queryRow();

		$model = $row['value'] . '_Class';
		Yii::import('application.models.payment.' . $model);
		$obj = new $model;
		$obj->beforeOrderProcess();
	}

	public function afterOrderProcess()
	{
		//$row = Configuration::model()->find('code="' . $_SESSION['payment_method']['id'] . '" and `key` like "PAYMENT_'.$_SESSION['payment_method']['id'].'_FILE"');
		$row = Yii::app()->db->createCommand("select * from {{configuration}} where code = '".$_SESSION['payment_method']['id']."' and `key` like 'PAYMENT_".$_SESSION['payment_method']['id']."_FILE'")->queryRow();
		$model = $row['value'] . '_Class';
		Yii::import('application.models.payment.' . $model);
		$obj = new $model;
		$obj->afterOrderProcess();
	}
}