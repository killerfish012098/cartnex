<div class="tab-pane active" id="Information">
    <div class="span12">
        <fieldset class="portlet" >
 
 <div class="portlet-decoration arrow-minus" onclick=" $('#hide_box_line1').slideToggle();">
<div class="span11">
<?php echo  Yii::t('manufacturers','heading_sub_title')?></div>
<div class="span1 Dev-arrow"><button class="btn btn-info arrow_main" id="hide_box_btn1" type="button"></button> </div>
<div class="clearfix"></div>	
</div>
  <div class="portlet-content " id="hide_box_line1">
     <div class="span5">	<?php 
	  
	  	echo $form->textFieldRow(
            $model[1],'name',
            array('rel'=>'tooltip','data-toggle'=>"tooltip",'data-placement'=>"right",)
        );
		?>
        </div>
		
		<div class="span5 uploading-img-main"> <?php
			/*if(Yii::app()->controller->action->id=='update'){*/
				echo $form->fileFieldRow(
				$model[0], 'image',
				array('name'=>'image', 'rel'=>'tooltip','data-toggle'=>"tooltip",'data-placement'=>"right", 'class'=>'Options_design'),
				
				array('hint' => '<div class="logo-img"><img src="'.Library::getCatalogUploadLink().$model[0]->image.'" ><input type="hidden" name="prev_file" value="'.$model[0]->image.'"></div>')
				);
				 echo '<p class="image-name-display">' .$model[0]->image. '</p>';
			/*}else{
				echo $form->fileFieldRow($model[0],'image');
			}*/
		?>
		</div>
		
		 <div class="span5">	<?php echo $form->textFieldRow(
            $model[0],  'sort_order',
            array('rel'=>'tooltip','data-toggle'=>"tooltip",'data-placement'=>"right",)
        ); 
		
		?>
        </div>
		
		 <div class="span5">	<?php echo $form->radioButtonListRow($model[0], 'status', array('1'=>'Enable','0'=>'Disable'));
			
        
		?>
        </div>
	</div>
    </fieldset>
 
        </div>   
 
 <div class="span12">
    <fieldset class="portlet" >
       <div class="portlet-decoration arrow-minus" onclick=" $('#hide_box_line2').slideToggle();">
<div class="span11">
<?php echo  Yii::t('manufacturers','SEO')?></div>
<div class="span1 Dev-arrow"><button class="btn btn-info arrow_main" type="button"></button> </div>
<div class="clearfix"></div>	
</div>
  <div class="portlet-content " id="hide_box_line2">
  
		 <div class="span5">	<?php echo $form->textFieldRow(
            $model[1],'meta_title',
            array('rel'=>'tooltip','data-toggle'=>"tooltip",'data-placement'=>"right",)
        ); 

		?>
        </div>
		
		 <div class="span5">	<?php echo $form->textFieldRow(
            $model[1],'meta_keywords',
            array('rel'=>'tooltip','data-toggle'=>"tooltip",'data-placement'=>"right",)
        ); 
		
		/*echo $form->textFieldRow(
            $model[1],'meta_description',
            array('rel'=>'tooltip','title'=>'sort_order','data-toggle'=>"tooltip",'data-placement'=>"right",)
        );*/
		
		
      ?>
        </div>
		
		 <div class="span11">	<?php  echo $form->labelEx($model[1],'meta_description').'<div class="controls">';
              $this->widget('bootstrap.widgets.TbCKEditor',
			  array( 'editorOptions'=>array('height'=>'100px','width'=>'100%',),
			  'model'=>    '$model[1]',
			  'name' => 'ManufacturerDescription[meta_description]',
			  'id'=>'ManufacturerDescription_meta_description',
			  'value'=>$model[1]->meta_description
			)
			);  echo $form->error($model[1],'meta_description');
            echo '</div>';
     ?>
        </div>
		
        </div>
    </fieldset>
        </div>
 </div>