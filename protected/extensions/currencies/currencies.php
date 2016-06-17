<?php 
class Currencies extends CWidget{
    public $currencyarray=array();
	public $defaultcurrency;
    public function init(){
	    return parent::init();
    }
	   public function run(){
		 if(sizeof(Yii::app()->config->getData('currencies'))>1){
         foreach(Yii::app()->config->getData('currencies') as $currency){
			 if(Yii::app()->session['currency']!=$currency['code']){
                 $this->currencyarray[]=array('label'=>$currency['symbol'], 'url'=>array('site/index','curr'=>$currency['code']));
			 }else{
				 $this->defaultcurrency=$currency['symbol'];
			 }
		 }
		 $this->render("currencies");
		 }
	}
}