<div class="tab-pane active" id="Information">
		<div class="span12">
			<fieldset class="portlet">

<div class="portlet-decoration arrow-minus" onclick=" $('#hide_box_line1').slideToggle();">
<div class="span11"><?php echo yii::t('productgroups','heading_sub_title');?> </div>
<div class="span1 Dev-arrow"><button class="btn btn-info arrow_main" id="hide_box_btn1" type="button"></button> </div>
<div class="clearfix"></div>
</div>
 <div class="portlet-content" id="hide_box_line1">
     <div class="span5">  <?php echo $form->textFieldRow(
           $model[1],'lable',
           array('rel'=>'tooltip','data-toggle'=>"tooltip",'data-placement'=>"right",)
       );?> </div>
                         <div class="span5"> <?php

	   echo $form->textFieldRow(
           $model[0],
           'set_title',
           array('rel'=>'tooltip','data-toggle'=>"tooltip",'data-placement'=>"right",)
       );  ?>
      </div>

         <div class="span5">  <div class="control-group"><label class="control-label" for="ProductGroup_sort_order">Select Products</label>
		<div class="controls">
        <?php
		foreach(Product::getProducts() as $pro):
				$data['product'][$pro->id_product]=$pro->name;
			endforeach;
			
		// added by fareed	
		if(Yii::app()->controller->action->id=='update'){        
			foreach(CHtml::listData(ProductGroupList::getProductGroupList($model[0]->id_product_group),'id_product','name') as $key=> $product):
				$data['selected'][$key]=array('selected'=>'selected');
			endforeach;
		}
        ?>
        <?php
		$this->widget(
				'bootstrap.widgets.TbSelect2',
				array(
					'name' => 'product_group',
					'data'=>$data['product'],
					'options' => array(
							'placeholder'=>'Search Product..',
                            ),
                    'htmlOptions' => array(
                            'options' => $data['selected'],
							'multiple' => 'multiple',
							'id' => 'issue-574-checker-select'   
							),           
				)
			);
        ?>
       				</div>
       			</div>
       		</div>

				   <div class="span5"> <?php

	   echo $form->checkboxRow(
           $model[0],
           'display_in_listing',
           array('rel'=>'tooltip','data-toggle'=>"tooltip",'data-placement'=>"right",)
       );  ?>
      </div>
	   </div>
   </fieldset> 
  </div>
</div>