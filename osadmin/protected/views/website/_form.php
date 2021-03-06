
<div class="row-fluid">
    <div class="tab-pane active" id="Information">
            <div class="span1['pd']">
                <fieldset class="portlet " >
                    <div class="portlet-decoration arrow-minus" onclick=" $('#hide_box_line5').slideToggle();">
                        <div class="span11">General </div>
                        <div class="span1 Dev-arrow"><button class="btn btn-info arrow_main" type="button"></button> </div>
                        <div class="clearfix"></div>	
                    </div>
                    <div class="portlet-content design_main_form" id="hide_box_line5">
						 <div class="span5">  <?php  echo $form->textFieldRow($model, 'CONFIG_WEBSITE_TEMPLATE', array(
														'rel' => 'tooltip', 'data-toggle' => "tooltip",'readonly'=>true,
														'data-placement' => "right",
										)
						);
						?></div>
										
                         <div class="span5">  <?php  echo $form->textFieldRow($model, 'CONFIG_WEBSITE_DEFAULT_WEIGHT', array(
                                                                            'rel' => 'tooltip', 'data-toggle' => "tooltip",
                                                                            'data-placement' => "right",
                                                            )
                                            );
											?></div>
                                            
                         <div class="span5">  <?php
                        echo $form->textFieldRow($model, 'CONFIG_WEBSITE_DEFAULT_LENGTH', array(
                                                                            'rel' => 'tooltip', 'data-toggle' => "tooltip",
                                                                            'data-placement' => "right",
                                                            )
                                            );
                         ?></div>

						 <div class="span5">  <?php
                        
                         echo $form->radioButtonListRow($model,
                                'CONFIG_WEBSITE_MAIL_PROTOCOL',
                                array(
                            'mail' => 'Mail',
                            'smtp' => 'SMTP',
                                )
                        );?>
						 
						 </div>

						 <div class="span5">  <?php
                        echo $form->textFieldRow($model, 'CONFIG_WEBSITE_SMTP_HOST', array(
                                                                            'rel' => 'tooltip', 'data-toggle' => "tooltip",
                                                                            'data-placement' => "right",
                                                            )
                                            );
                         ?></div>
						 <div class="span5">  <?php
                        echo $form->textFieldRow($model, 'CONFIG_WEBSITE_SMTP_USERNAME', array(
                                                                            'rel' => 'tooltip', 'data-toggle' => "tooltip",
                                                                            'data-placement' => "right",
                                                            )
                                            );
                         ?></div>
						 <div class="span5">  <?php
                        echo $form->passwordFieldRow($model, 'CONFIG_WEBSITE_SMTP_PASSWORD', array(
                                                                            'rel' => 'tooltip', 'data-toggle' => "tooltip",
                                                                            'data-placement' => "right",
                                                            )
                                            );
                         ?></div>
						 <div class="span5">  <?php
                        echo $form->textFieldRow($model, 'CONFIG_WEBSITE_SMTP_PORT', array(
                                                                            'rel' => 'tooltip', 'data-toggle' => "tooltip",
                                                                            'data-placement' => "right",
                                                            )
                                            );
                         ?></div>
						 <div class="span5">  <?php
                        echo $form->textFieldRow($model, 'CONFIG_WEBSITE_SMTP_TIMEOUT', array(
                                                                            'rel' => 'tooltip', 'data-toggle' => "tooltip",
                                                                            'data-placement' => "right",
                                                            )
                                            );
                         ?></div>
                                            
                         <div class="span5">  <?php
						

						 echo $form->radioButtonListRow($model,'CONFIG_WEBSITE_ADDTOCART_REDIRECT',array(
																								'1'=>Yii::t('common','text_yes'),
																								'0'=>Yii::t('common','text_no'),
																								)
																						);?></div>
                                            
                       <div class="span5">
                        <?php
                        echo $form->textAreaRow($model, 'CONFIG_WEBSITE_ALLOWED_FILE_TYPES',
                                array(
                            'rel' => 'tooltip',  'data-toggle' => "tooltip",
                            'data-placement' => "right",
                                )
                        );
                        ?>
                    </div>
						 
						 <div class="span5">  <?php

						echo $form->dropDownListRow($model, 'CONFIG_WEBSITE_DEFAULT_CUSTOMER_GROUP', CHtml::listData(CustomerGroup::getCustomerGroups(), 'id_customer_group', 'name'));?></div>
                                            
                         <div class="span5">  <?php
						
						echo $form->dropDownListRow($model, 'CONFIG_WEBSITE_COMPLETE_ORDER_STATUS', CHtml::listData(OrderStatus::getOrderStatuses(), 'id_order_status', 'name'));?></div>
                                            
                       
                                            
                         <div class="span5">  <?php
                        
                         echo $form->textFieldRow($model, 'CONFIG_WEBSITE_CACHE_LIFE_TIME', array(
                                                                            'rel' => 'tooltip', 'data-toggle' => "tooltip",
                                                                            'data-placement' => "right",
                                                            )
                                            );?></div>
                                            
                         <div class="span5">  <?php
                         
						 echo $form->radioButtonListRow($model,'CONFIG_WEBSITE_MAINTENANCE_MODE',array(
																								'1'=>Yii::t('common','text_yes'),
																								'0'=>Yii::t('common','text_no'),
																								)
																						); ?></div>
                                            
                       
                                            
                      
                                            
                         <div class="span5">  <?php

						echo $form->textFieldRow($model, 'CONFIG_WEBSITE_PRODUCT_NAME_LIMIT', array(
                                                                            'rel' => 'tooltip', 'data-toggle' => "tooltip",
                                                                            'data-placement' => "right",
                                                            )
                                            );?></div>
                                            
 
                                            
                         <div class="span5">  <?php

						echo $form->textFieldRow($model, 'CONFIG_WEBSITE_ITEMS_PER_PAGE', array(
                                                                            'rel' => 'tooltip', 'data-toggle' => "tooltip",
                                                                            'data-placement' => "right",
                                                            )
                                            );?></div>
                                            
                         <div class="span5">  <?php

						echo $form->textFieldRow($model, 'CONFIG_WEBSITE_ITEMS_PER_PAGE_ADMIN', array(
                                                                            'rel' => 'tooltip', 'data-toggle' => "tooltip",
                                                                            'data-placement' => "right",
                                                            )
                                            );?></div>
                                            
                                           
                         <div class="span5">  <?php
						 echo $form->radioButtonListRow($model,'CONFIG_WEBSITE_DEFAULT_PRODUCT_LIST_VIEW',array(
																                'list'=>Yii::t('common','List'),
																				'grid'=>Yii::t('common','Grid'),
																				)
														);
						
                        ?></div>
                        
                        
                        
                          <div class="span10">  <?php

                        echo $form->textAreaRow($model, 'CONFIG_WEBSITE_GOOGLE_ANALYTICS', array(
                                                                            'rel' => 'tooltip', 'data-toggle' => "tooltip",
                                                                            'data-placement' => "right",
                                                            )
                                            );?></div>
                                            
                                            
                                               <div class="span10">  <?php

                         echo $form->textFieldRow($model, 'CONFIG_WEBSITE_META_TITLE', array(
                                                                            'rel' => 'tooltip', 'data-toggle' => "tooltip",
                                                                            'data-placement' => "right",
                                                            )
                                            );?></div>
                                            
                         <div class="span10">  <?php
                         
                         echo $form->textAreaRow($model, 'CONFIG_WEBSITE_META_KEYWORDS', array(
                                                                            'rel' => 'tooltip', 'data-toggle' => "tooltip",
                                                                            'data-placement' => "right",
                                                            )
                                            );?></div>
                                            
                         <div class="span10">  <?php

                         echo $form->textAreaRow($model, 'CONFIG_WEBSITE_META_DESCRIPTION', array(
                                                                            'rel' => 'tooltip', 'data-toggle' => "tooltip",
                                                                            'data-placement' => "right",
                                                            )
                                            );?></div>
                                            
                                              <div class="span10">  <?php

						echo $form->textAreaRow($model, 'CONFIG_WEBSITE_MAINTENANCE_MESSAGE', array(
																				'rel' => 'tooltip', 'data-toggle' => "tooltip",
																				'data-placement' => "right",
																				)
																	);?></div>
                                            
                           <div class="span10"> <?php
						
							echo $form->textAreaRow($model, 'CONFIG_WEBSITE_COPYRIGHTS', array(
                                                                            'rel' => 'tooltip', 'data-toggle' => "tooltip",
                                                                            'data-placement' => "right",
                                                            )
                                            ); ?></div>
                                            

                    </div>
                </fieldset>

            </div>  
    </div>
</div>