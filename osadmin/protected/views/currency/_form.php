<div class="tab-pane active" id="Information">
<div class="span12">
<fieldset class="portlet">
<div class="portlet-decoration arrow-minus" onclick=" $('#hide_box_line1').slideToggle();">
<div class="span11"><?php echo Yii::t('currencies','heading_sub_title')?> </div>
<div class="span1 Dev-arrow"><button class="btn btn-info arrow_main" type="button"></button> </div>
<div class="clearfix"></div>
</div>

 <div class="portlet-content" id="hide_box_line1">
   <div class="span5">  <?php echo $form->textFieldRow(
           $model,'name',
           array('rel'=>'tooltip','data-toggle'=>"tooltip",'data-placement'=>"right",)
       );?>       </div>
       
 <div class="span5"> 
	   <?php echo $form->textFieldRow(
           $model,'value',
           array('rel'=>'tooltip','data-toggle'=>"tooltip",'data-placement'=>"right",)
       ); ?>	   </div>
       
       <div class="span5">  <?php 
	   echo $form->textFieldRow(
           $model, 'code',
           array('rel'=>'tooltip','data-toggle'=>"tooltip",'data-placement'=>"right",)
       );  ?> </div>
       
       <div class="span5">  <?php  echo $form->textFieldRow(
           $model,'symbol',
           array('rel'=>'tooltip','data-toggle'=>"tooltip",'data-placement'=>"right",)
       );  ?>  </div>
       
              <div class="span5">  <?php  echo $form->radioButtonListRow($model,'position', array('RIGHT'=>'Rigfht','LEFT'=>'Left'));
	     ?></div>
         
       <div class="span5">  <?php echo $form->textFieldRow(
           $model,'decimal_separator',
           array('rel'=>'tooltip','data-toggle'=>"tooltip",'data-placement'=>"right",)
       ); 
	    ?> </div>
        
       <div class="span5">  <?php  echo $form->textFieldRow(
           $model,'thousand_separator',
           array('rel'=>'tooltip','data-toggle'=>"tooltip",'data-placement'=>"right",)
       );  ?></div>
       
       <div class="span5"> 
	   <?php  echo $form->textFieldRow(
           $model,'decimals',
           array('rel'=>'tooltip','data-toggle'=>"tooltip",'data-placement'=>"right",)
       );  ?>
	 </div>
       <div class="span5">  <?php  echo $form->radioButtonListRow($model, 'status',  array('1'=>'Enable','0'=>'Disable'));
        ?>
       </div>
   </fieldset>

       </div>  
  </div>
</div>