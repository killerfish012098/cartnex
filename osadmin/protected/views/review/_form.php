<div class="tab-pane active" id="Information">
<div class="span12">
 <fieldset class="portlet">
	<div class="portlet-decoration arrow-minus" onclick=" $('#hide_box_line1').slideToggle();">
<div class="span11"><?php echo Yii::t('reviews','heading_sub_title')?></div>
<div class="span1 Dev-arrow"><button class="btn btn-info arrow_main" type="button"></button> </div>
<div class="clearfix"></div>
</div>
 <div class="portlet-content" id="hide_box_line1">
			<div class="span5"><?php
				foreach(Product::getProducts() as $pro):
						$data['product'][$pro->id_product]=$pro->name;
				endforeach;
			?>
            
            <div class="control-group"><label class="control-label"><?php echo Yii::t('reviews','entry_product'); ?></label>
            <div class="controls">
			<?php $this->widget('bootstrap.widgets.TbSelect2', array('name' => 'Review[id_product]','data'=>$data['product'], 'options' => array('placeholder'=>'Search Product..',), 'htmlOptions' => array('options' => array($model->id_product => array('selected' => 'selected')), 'id' => 'issue-574-checker-select')));?></div>
            
            </div>
</div>
		
		<div class="span5">	<?php 
			echo $form->textFieldRow(
			$model,'customer_name',
			array('rel'=>'tooltip','data-toggle'=>"tooltip",'data-placement'=>"right",)
			);  ?>
		</div>
			
        <div class="span5"><?php echo $form->radioButtonListRow($model, 'status', array('1'=>'Enable','0'=>'Disable')); ?></div>
            
        <div class="span5">
			<div class="control-group"><label class="control-label"><?php echo Yii::t('reviews','entry_rating'); ?></label>
				<div class="controls">
				<?php $this->widget('ext.DzRaty.DzRaty', array( 'model' => $model, 'attribute' => 'rating',));  ?>
				</div>
            </div>
        </div>
            
		<div class="span11"><?php echo $form->textAreaRow($model, 'text', array( 'rows'=>5)); ?></div>
	</div>
   </fieldset>

       </div>  
  </div>