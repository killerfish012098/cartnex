	<div class="tab-pane active" id="Information">
		<div class="span12">
			 <fieldset class="portlet " >

      <div class="portlet-decoration arrow-minus" onclick=" $('#hide_box_line1').slideToggle();">
<div class="span11"><?php echo Yii::t('stockstatus','heading_sub_title')?></div>
<div class="span1 Dev-arrow"><button class="btn btn-info arrow_main" id="hide_box_btn1" type="button"></button> </div>
<div class="clearfix"></div>
</div>
			 <div class="portlet-content" id="hide_box_line1">
			 
			 <?php echo $form->textFieldRow(
          	 $model['s'],'name',
          	 array('rel'=>'tooltip','data-toggle'=>"tooltip",'data-placement'=>"right",)
			//array('hint' => 'In addition to freeform text, any HTML5 text-based input appears like so.')
      			 ); ?>  
	   
	 
      		 </div>
   		</fieldset>
    </div>  
</div>