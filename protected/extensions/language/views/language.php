<?php 
/*echo '<pre>';
print_r($this->languagearray);
echo '</pre>';
exit;*/
/*Yii::app()->session['CONFIG_STORE_DEFAULT_LANGUAGES']=Yii::app()->session['CONFIG_STORE_DEFAULT_LANGUAGES']?Yii::app()->session['CONFIG_STORE_DEFAULT_LANGUAGES']:Yii::app()->session['CONFIG_STORE_DEFAULT_LANGUAGE'];*/
$this->widget('zii.widgets.CMenu',array(
  'activeCssClass'=>'active',
  'activateParents'=>true, 
  'htmlOptions'=>array('class'=>'marrign-left-div'),
  'items'=>array(
    array(
      'label'=>Yii::app()->session['language'],//Yii::app()->session['CONFIG_STORE_DEFAULT_LANGUAGES'],
      'url'=>array('#'),
	  'htmlOptions'=>array('class'=>'div-left-div'),
      'linkOptions'=>array('id'=>'menuCompany'),
      'itemOptions'=>array('id'=>'itemCompany'),
      'items'=>$this->languagearray,
    ),
    
  ),
));
?>