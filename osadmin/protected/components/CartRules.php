<?php
class CartRules 
{
    
    public function init() 
    {
    }
    
    public function getActiveCRules()
    {
        return Configuration::model()->findAll('`key` like "CARTRULE_%_STATUS"');
    }
    
    public function loadRules()
    {
    $rows=$this->getActiveCRules();
        //echo '<pre>';
        $data=array();
        foreach($rows as $row):
            $data['code'][]=$row->code;
            $confVal=Configuration::model()->find('code="'.$row->code.'" and `key` like "CARTRULE_'.$row->code.'_SORT_ORDER"');
            $data['sort'][]=$confVal->value;
        endforeach;
        //print_r($data);
        array_multisort($data['sort'], SORT_ASC, $data['code']);
        //print_r($data);
        
        $cartRule=array();
        $cartRule['total']='100';
        foreach($data['code'] as $code):
            $confVal=Configuration::model()->find('code="'.$code.'" and `key` like "CARTRULE_'.$code.'_FILE"');
            Yii::import('application.models.cartrules.'.trim($confVal->value).'_Class');
            $class=trim($confVal->value).'_Class';
            $obj=new $class;
            $obj->applyRule($cartRule);
        endforeach;
        /*echo '<pre>';
        print_r($cartRule);
        exit("in cart rule");*/
        return $cartRule;
        /*$rows=$this->getActiveCRules();
        foreach($rows as $row):
        echo $row->key." ".$row->value." ".$row->code."<br/>";    
        $this->getCRuleDetails(array('code'=>$row->code));
        endforeach;
        exit("in cart rule");*/
    }
}
