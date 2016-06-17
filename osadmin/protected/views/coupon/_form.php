
<div class="row-fluid">
    <div class="tab-pane active" id="Information">
    
            <div class="span12">
                <fieldset class="portlet " >
                   <div class="portlet-decoration arrow-minus" onclick=" $('#hide_box_line1').slideToggle();">
                        <div class="span11"><?php echo yii::t('coupons','heading_sub_title_details');?> </div>
                        <div class="span1 Dev-arrow"><button class="btn btn-info arrow_main" type="button"></button> </div>
                        <div class="clearfix"></div>	
                    </div>
                    <div class="portlet-content" id="hide_box_line1">
                      <div class="span5">   <?php
                        echo $form->textFieldRow(
                                $model['c'], 'name',
                                array('rel' => 'tooltip','data-toggle' => "tooltip",'data-placement' => "right",)
                        );?></div>
                        
                         <div class="span5">   <?php echo $form->textFieldRow(
                                $model['c'], 'code',
                                array('rel' => 'tooltip','data-toggle' => "tooltip",'data-placement' => "right",)
                        );
                         ?></div>
                        
						 <div class="span11">   <?php echo $form->radioButtonListRow($model['c'], 'type', array('F'=>'Fixed Amount','P'=>'Percentage Discount'));
						?></div>

                    </div> 

    </fieldset>
            </div>
            
            
            <div class="span12">
                <fieldset class="portlet " >
                   <div class="portlet-decoration arrow-minus" onclick=" $('#hide_box_line2').slideToggle();">
                        <div class="span11"><?php echo yii::t('coupons','heading_sub_title_applicable');?> </div>
                        <div class="span1 Dev-arrow"><button class="btn btn-info arrow_main" type="button"></button> </div>
                        <div class="clearfix"></div>	
                    </div>
                    <div class="portlet-content" id="hide_box_line2">
                    
                         <div class="span5">   <?php echo $form->radioButtonListRow($model['c'], 'logged', array('1'=>'Yes','0'=>'No'));
						?></div>
                        
						 <div class="span5">  	<div class="control-group"><label class="control-label" for="ProductGroup_sort_order"><?php echo Yii::t('coupons','entry_product');?></label>
							<div class="controls">
							<?php
							foreach(Product::getProducts() as $pro):
									$data['product'][$pro->id_product]=$pro->name;
								endforeach;
							if(Yii::app()->controller->action->id=='update'){        
								foreach(CHtml::listData(CouponProduct::getProductCouponList($model['c']->id_coupon),'id_product','name') as $key=> $product):
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
						   </div></div>
				</fieldset>
            </div>
            
            
            
            <div class="span12">
                <fieldset class="portlet " >
                   <div class="portlet-decoration arrow-minus" onclick=" $('#hide_box_line3').slideToggle();">
                        <div class="span11"><?php echo yii::t('coupons','heading_sub_title_settings');?></div>
                        <div class="span1 Dev-arrow"><button class="btn btn-info arrow_main" type="button"></button> </div>
                        <div class="clearfix"></div>	
                    </div>
                    <div class="portlet-content" id="hide_box_line3">
                    
					 
                              <div class="span5">   <?php  echo $form->textFieldRow(
                                $model['c'], 'discount',
                                array('rel' => 'tooltip','data-toggle' => "tooltip",
                            'data-placement' => "right",)
                        );?></div>
                        
                      
						<div class="span5">   <?php  echo $form->textFieldRow(
                                $model['c'], 'total',
                                array('rel' => 'tooltip','data-toggle' => "tooltip",
                            'data-placement' => "right",)
                        );
						?></div>
                        

                           <div class="span5">   <?php 
                           echo $form->datepickerRow(
                                $model['c'], 'date_start', array(
                            'options' => array(
                                'language' => Yii::app()->language,
                                'format' => 'yyyy-mm-dd',
                                'viewformat' => 'yyyy-mm-dd', //'mm/dd/yyyy',
                            ),
                            'htmlOptions' => array(
                            )
                                ), array(
                            'prepend' => '<i class="icon-calendar"></i>'
                                )
                        );
                           ?></div>
                       
                        
                         <div class="span5">   <?php 
                           echo $form->datepickerRow(
                                $model['c'], 'date_end', array(
                            'options' => array(
                                'language' => Yii::app()->language,
                                'format' => 'yyyy-mm-dd',
                                'viewformat' => 'yyyy-mm-dd', //'mm/dd/yyyy',
                            ),
                            'htmlOptions' => array(
                            )
                                ), array(
                            'prepend' => '<i class="icon-calendar"></i>'
                                )
                        );
                           ?></div>
                        
                         <div class="span5">   <?php echo $form->textFieldRow(
                                $model['c'], 'uses_total',
                                array('rel' => 'tooltip', 'data-toggle' => "tooltip",
                            'data-placement' => "right",)
                        );?></div>
                        
                         <div class="span5">   <?php echo $form->textFieldRow(
                                $model['c'], 'uses_customer',
                                array('rel' => 'tooltip', 'data-toggle' => "tooltip",
                            'data-placement' => "right",)
                        );?></div>
                        
                         <div class="span5">	<?php 
						 if(Yii::app()->controller->action->id=='update'){
							echo $form->radioButtonListRow($model['c'], 'status', array('1'=>'Enable','0'=>'Disable'));
						 }else{
							 $model['c']->status=1;
							 echo $form->radioButtonListRow($model['c'], 'status', array('1'=>'Enable','0'=>'Disable'));
						 }
						?>
						</div>
                        
				  </div>
    </fieldset>
            </div>
            <?php 
			if(Yii::app()->controller->action->id=='update'){  
			?>
             <div class="span12">
                <fieldset class="portlet " >
                    <div class="portlet-decoration" onclick=" $('#hide_box_line4').slideToggle();">
                        <div class="span11"><?php echo yii::t('coupons','heading_coupon_history');?> </div>
                        <div class="span1 Dev-arrow"><button class="btn btn-info arrow_main" type="button"></button> </div>
                        <div class="clearfix"></div>	
                    </div>
                    <div class="portlet-content" id="hide_box_line4" style="display:none;">
                    

                         
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Order Id <?php //echo  Yii::t('options','entry_option_name');?></th>
                                    <th>Customer <?php //echo  Yii::t('options','entry_option_image');?></th>
                                    <th>Amount   <?php //echo  Yii::t('options','entry_option_sort_order');?></th>
                                    <th>Date Added   <?php //echo  Yii::t('options','entry_option_sort_order');?></th>
                                </tr>
                            </thead>

                            <?php
							//echo '<pre>';print_r($model['ch']);echo '</pre>';
                            $row = 0;
							if(sizeof($model['ch'])){
                            foreach ($model['ch'] as $model):
                                ?>
                                <tbody id='row-<?php echo $row; ?>'>
                                <tr>
									<td style="width: 60px"><?php echo $model['id_order'];?></td>
									<td style="width: 60px">
									<?php //echo  "customer id is  : ".$model['id_customer'];//
									echo Customer::getCustomerName($model['id_customer']);?>
									</td>
									<td style="width: 60px"><?php echo $model['amount'];?></td>
									<td style="width: 60px"><?php echo $model['date_created'];?></td>
                                </tr>
                                </tbody>
                                            <?php
                                        endforeach;
							}else{ echo '<tbody><tr><td colspan="4"><center>No Records Found!!</center></td></tr></tbody>';}
                                        ?>
                        </table>
 
                    </div>
           </div>
		   <?php  } ?>
		   </div>	
                    </div> 

    </fieldset>
   </div>

