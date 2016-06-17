<div class="row-fluid">
 <div class="tab-pane active" id="Information">
	<div class="span12">
   		<fieldset class="portlet " >

     <div class="portlet-decoration arrow-minus" onclick=" $('#hide_box_line2').slideToggle();">
<div class="span11"><?php echo Yii::t('orderstatus','heading_sub_title');?></div>
<div class="span1 Dev-arrow"><button class="btn btn-info arrow_main" type="button"></button> </div>
<div class="clearfix"></div>
</div>
 <div class="portlet-content" id="hide_box_line2">
 	<div class="span5"> <?php echo $form->textFieldRow(
           $model['o'],'name',
           array('rel'=>'tooltip','data-toggle'=>"tooltip",'data-placement'=>"right",)
       );
?> </div>
		<div class="span5">
       <?php  echo $form->colorpickerRow(
			$model['o'],
			'color'
		); 
	   ?></div>
       

       <div class="span10"><?php 
	    $list=CHtml::listData(EmailTemplate::getEmailTemplates(),'id_email_template','title');
        echo $form->dropDownListRow($model['o'],'id_email_template', $list);
     ?></div>
      
       </div>
   </fieldset>

       </div>  
  </div>
</div>