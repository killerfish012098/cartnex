<?php
class Shipping 
{
    
    public function init() 
    {
            
    }
    
    public function getActiveCRules()
    {
        //return Configuration1::model()->findAll('`key` like "SHIPPING_%_STATUS" and value="1"');
		return Yii::app()->db->createCommand("select * from {{configuration}} where `key` like 'SHIPPING_%_STATUS' and value='1'")->queryAll();
    }
    
    public function getMethods() {

        //$rows = ConfigurationGroup::model()->findAll('type="SHIPPING"');
		$rows = Yii::app()->db->createCommand("select * from {{configuration_group}} where type='SHIPPING'")->queryAll();
        $data = array();
        foreach ($rows as $row) {
            //$methods = Configuration::model()->findAll('code="' . $row['code'] . '"');
			$methods = Yii::app()->db->createCommand("select * from {{configuration}} where code='".$row['code']."'")->queryAll();
			//echo '<pre>';print_r($methods);echo '</pre>';
            foreach ($methods as $method) {
                //$data[$method->code][$method->attributes['key']] = $method->attributes['value'];
				$data[$method['code']][$method['key']] = $method['value'];
            }
			//echo '<pre>';print_r($data);echo '</pre>';exit;
        }

        $gateway = array();
        foreach ($data as $k => $v) {
            if ($v['SHIPPING_' . $k . '_STATUS'] == 1) {
                $model = $v['SHIPPING_' . $k . '_FILE'] . '_Class';
                Yii::import('application.models.shipping.' . $model);
                $obj = new $model;
                if ($obj->isAllowed()) {
                    $gateway['code'][$k] =$obj->getQuote();
                    $gateway['sort_order'][] = $v['SHIPPING_' . $k . '_SORT_ORDER'];
                }
            }
        }

        array_multisort($gateway['sort_order'], SORT_ASC, $gateway['code']);
        
        return $gateway['code'];
    }

	public function getMethod($shipping)
	{
		list($module, $method) = explode('-', $shipping);
		//$row = Configuration::model()->find('code="' . $module . '" and `key` like "SHIPPING_'.$module.'_FILE"');
		$row =Yii::app()->db->createCommand("select * from {{configuration}} where code='".$module."' and `key` like 'SHIPPING_".$module."_FILE'")->queryRow();
		$model = $row['value'].'_Class';
		Yii::import('application.models.shipping.' . $model);
		$obj = new $model;
		$quote=$obj->getQuote();
		//echo $shipping.' ss <pre>';print_r($quote);echo '</pre>';
		return array('id'=>$shipping,
					 'title'=>$quote['title']."(".$quote['methods'][$module]['title'].")",
					 'cost'=>$quote['methods'][$module]['cost'],
					 );
	}
    
    public function getMethods1()
    {
        //load active models from db & isAllowed function
        //call getQuote method from respective models
        //return array of methods
        
        
        return  array( array('code' => 'Flat', //code
                            'title' => 'Shipping Method', //title
                            'methods' => array(
                                            array('code' => 'Flat', //code
                                                'title' => 'Express', //title
                                                'cost' => '5.00'
                                                )
                                        )
                            )
                    );
    }
    
    
    public function selected()
    {
        return 'code';
    }
    
    public function loadMethods()
    {
        $rows=$this->getActiveCRules();
        echo '<pre>';
        $data=array();
        foreach($rows as $row):
            $data['code'][]=$row['code'];
            //$confVal=Configuration::model()->find('code="'.$row['code'].'" and `key` like "SHIPPING_'.$row['code'].'_SORT_ORDER"');
            $confVal =Yii::app()->db->createCommand("select * from {{configuration}} where code='".$row['code']."' and `key` like 'SHIPPING_".$row['code']."_SORT_ORDER'")->queryRow();
			$data['sort'][]=$confVal['value'];
        endforeach;
        //print_r($data);
        array_multisort($data['sort'], SORT_ASC, $data['code']);
        //print_r($data);
        //exit;
        $cartRule=array();
        $cartRule['total']='100';
        foreach($data['code'] as $code):
            //$confVal=Configuration::model()->find('code="'.$code.'" and `key` like "CARTRULE_'.$code.'_FILE"');
		$confVal =Yii::app()->db->createCommand("select * from {{configuration}} where code='".$code."' and `key` like 'CARTRULE_".$code."_FILE'")->queryRow();
            Yii::import('application.models.cartrules.'.trim($confVal['value']).'_Class');
            $class=trim($confVal->value).'_Class';
            $obj=new $class;
            $obj->applyRule($cartRule);
        endforeach;
        return $cartRule;
    }
}
