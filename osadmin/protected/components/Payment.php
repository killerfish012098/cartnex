<?php

class Payment {

    public function init() {
        
    }

    public function getMethods() {

        $rows = ConfigurationGroup::model()->findAll('type="PAYMENT"');
        $data = array();
        foreach ($rows as $row) {
            $methods = Configuration::model()->findAll('code="' . $row->code . '"');
            foreach ($methods as $method) {
                $data[$method->code][$method->attributes['key']] = $method->attributes['value'];
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
          //Configuration1::model()->
          //load active models from db  & isAllowed function
          //call getQuote method from respective models
          //return array of methods
         */

        return $gateway['code'];
    }
}
