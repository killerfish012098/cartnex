<?php
class CartRules 
{
	public $total=null;
    public function init() 
    {
    
	}
    
    public function getActiveCRules()
    {
        //return Configuration::model()->findAll('`key` like "CARTRULE_%_STATUS"');
		return Yii::app()->db->createCommand("select * from {{configuration}} where `key` like 'CARTRULE_%_STATUS'")->queryAll();
    }
    
    public function loadRules()
    {
        $rows=$this->getActiveCRules();
        $data=array();
        foreach($rows as $row):
            $data['code'][]=$row['code'];
            //$confVal=Configuration::model()->find('code="'.$row['code'].'" and `key` like "CARTRULE_'.$row['code'].'_SORT_ORDER"');
			$confVal=Yii::app()->db->createCommand("select * from {{configuration}} where code='".$row['code']."' and `key` like 'CARTRULE_".$row['code']."_SORT_ORDER'")->queryRow();
			
            $data['sort'][]=$confVal['value'];
        endforeach;
        //print_r($data);
        array_multisort($data['sort'], SORT_ASC, $data['code']);
        //print_r($data);
        
        $cartRule=array();
        //$cartRule['total']=Yii::app()->session['user_total_price'];
        foreach($data['code'] as $code):
            //$confVal=Configuration::model()->find('code="'.$code.'" and `key` like "CARTRULE_'.$code.'_FILE"');
		$confVal=Yii::app()->db->createCommand("select * from {{configuration}} where code='".$code."' and `key` like 'CARTRULE_".$code."_FILE'")->queryRow();
            Yii::import('application.models.cartrules.'.trim($confVal['value']).'_Class');
            $class=trim($confVal['value']).'_Class';
            $obj=new $class;
             Yii::app()->currency->format($obj->applyRule($cartRule));
        endforeach;
        /*echo '<pre>';
        print_r($cartRule);
        exit("in cart rule");*/
		//exit("value of ".$cartRule['total']);
		$this->total=$cartRule['total'];
        return $cartRule;
        /*$rows=$this->getActiveCRules();
        foreach($rows as $row):
        echo $row->key." ".$row->value." ".$row->code."<br/>";    
        $this->getCRuleDetails(array('code'=>$row->code));
        endforeach;
        exit("in cart rule");*/
    }
}
