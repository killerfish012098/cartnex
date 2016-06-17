<?php

class TaxClass 
{
    private $db;
    private $id_language;
    public function init()
    {
		$languages=Yii::app()->config->getData('languages');
        $this->id_language=$languages[Yii::app()->session['language']]['id_language'];
        $this->db = Yii::app()->db;
    }
    
    public function calculate($value,$tax_class_id, $calculate = true) 
    {
        $amount = 0;
        if ($tax_class_id && $calculate) 
        {
            //exit('calculate in if');
            $taxes = $this->getRates($value,$tax_class_id);
            $details=array();
            foreach($taxes as $tax)
            {
                $amount+=$tax['amount'];
                $details[]=array('name'=>$tax['name'],
                                'amount'=>$tax['amount']
                            );
            }
            return array('amount'=>$amount,'details'=>$details);
        } else 
        {
            return 0;
        }
    }
    
    public function getRates($value,$id_tax_class)
    {
        //$_SESSION['shipping']['id_country']='99';
        //$_SESSION['shipping']['id_state']='1476';
        $tax_rates=array();
        if($_SESSION['shipping']['id_country']!="" && $_SESSION['shipping']['id_state']!="")
        {
            $rows=$this->db->createCommand("select tcr.id_tax_class_rule,tcrd.name,tcr.id_tax_class,tcr.rate,tcr.type,tcr.based_on from r_tax_class_rule tcr,r_tax_class_rule_description tcrd ,r_region_list rl where tcr.id_tax_class_rule=tcrd.id_tax_class_rule and tcrd.id_language='".$this->id_language."' and tcr.id_tax_class='".$id_tax_class."' and tcr.based_on='SHIPPING_ADDR' and tcr.id_region=rl.id_region and rl.id_country='".$_SESSION['shipping']['id_country']."' and rl.id_state='".$_SESSION['shipping']['id_state']."'")->queryAll();
            foreach($rows as $row)
            {
                $tax_rates[$row['id_tax_class_rule']]=array(
                                        'id_tax_class_rule' => $row['id_tax_class_rule'],
					'name'        => $row['name'],
					'rate'        => $row['rate'],
					'type'        => $row['type'],
                );
            }
        }
        //echo '<pre>last';print_r($tax_rates);print_r($tax_rate_data);echo '</pre>';exit;
        if($_SESSION['billing']['id_country']!="" && $_SESSION['billing']['id_state']!="")
        {
            //echo '<br/> in payment';
            $rows=$this->db->createCommand("select tcrd.name,tcr.id_tax_class,tcr.rate,tcr.type,tcr.based_on from r_tax_class_rule tcr,r_tax_class_rule_description tcrd ,r_region_list rl where tcr.id_tax_class_rule=tcrd.id_tax_class_rule and tcrd.id_language='".$this->id_language."' and tcr.id_tax_class='".$id_tax_class."' and tcr.based_on='PAYMENT_ADDR' and tcr.id_region=rl.id_region and rl.id_country='".$_SESSION['billing']['id_country']."' and rl.id_state='".$_SESSION['billing']['id_state']."'")->queryAll();
        
            foreach($rows as $row)
            {
                $tax_rates[$row['id_tax_class_rule']]=array(
                                        'id_tax_class_rule' => $row['id_tax_class_rule'],
					'name'        => $row['name'],
					'rate'        => $row['rate'],
					'type'        => $row['type'],
                );
            }
        }
        
        $tax_rate_data = array();
        foreach ($tax_rates as $tax_rate) 
        {
            if (isset($tax_rate_data[$tax_rate['id_tax_class_rule']])) 
            {
                $amount = $tax_rate_data[$tax_rate['id_tax_class_rule']]['amount'];
            } else 
            {
                $amount = 0;
            }

            if ($tax_rate['type'] == 'FIXED') {
                    $amount += $tax_rate['rate'];
            } elseif ($tax_rate['type'] == 'PERCENT') {
                    $amount += ($value / 100 * $tax_rate['rate']);
            }

            $tax_rate_data[$tax_rate['id_tax_class_rule']] = array(
                    'id_tax_class_rule' => $tax_rate['id_tax_class_rule'],
                    'name'        => $tax_rate['name'],
                    'rate'        => $tax_rate['rate'],
                    'type'        => $tax_rate['type'],
                    'amount'      => $amount
            );
	}
        return $tax_rate_data;
    }
}
