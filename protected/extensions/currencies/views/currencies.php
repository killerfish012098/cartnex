<?php 
$this->widget('zii.widgets.CMenu',array(
  'activeCssClass'=>'active',
  'activateParents'=>true, 
  'htmlOptions'=>array('class'=>'marrign-left-div'),
  'items'=>array(
    array(
      'label'=>$this->defaultcurrency,
      'url'=>array('#'),
	  'htmlOptions'=>array('class'=>'div-left-div'),
      'linkOptions'=>array('id'=>'menuCompany'),
      'itemOptions'=>array('id'=>'itemCompany'),
      'items'=>$this->currencyarray,
    ),
    
  ),
));
?>