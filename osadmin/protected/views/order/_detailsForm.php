<div class="row-fluid">
    <div class="tab-pane active" id="Information">
            <div class="span12">
                <fieldset class="portlet " >
                    <div class="portlet-decoration arrow-minus" onclick=" $('#hide_box_line6').slideToggle();">
                        <div class="span11"><?php echo yii::t('orders','heading_sub_title_payment_details');?> </div>
                        <div class="span1 Dev-arrow"><button class="btn btn-info arrow_main" type="button"></button> </div>
                        <div class="clearfix"></div>	
                    </div>
                    <div class="portlet-content" id="hide_box_line6">
                      <div class="span5">  <?php
                        echo $form->textFieldRow(
                                $model['o'], 'billing_firstname',
                                array('rel' => 'tooltip',  'data-toggle' => "tooltip",
                            'data-placement' => "right",)
                        );?>
</div>
                         <div class="span5"> <?php echo $form->textFieldRow(
                                $model['o'], 'billing_lastname',
                                array('rel' => 'tooltip',  'data-toggle' => "tooltip",
                            'data-placement' => "right",)
                        );?>
</div>
                         <div class="span5"> <?php echo $form->textFieldRow(
                                $model['o'], 'billing_company',
                                array('rel' => 'tooltip',  'data-toggle' => "tooltip",
                            'data-placement' => "right",)
                        );?>
</div>
                         <div class="span5"> <?php  echo $form->textFieldRow(
                                $model['o'], 'billing_address_1',
                                array('rel' => 'tooltip','data-toggle' => "tooltip",
                            'data-placement' => "right",)
                        );?>
</div>
                         <div class="span5"> <?php  echo $form->textFieldRow(
                                $model['o'], 'billing_address_2',
                                array('rel' => 'tooltip', 'data-toggle' => "tooltip",
                            'data-placement' => "right",)
                        );?>
</div>
                         <div class="span5"> <?php   echo $form->textFieldRow(
                                $model['o'], 'billing_city',
                                array('rel' => 'tooltip',  'data-toggle' => "tooltip",
                            'data-placement' => "right",)
                        );?>
</div>
                         <div class="span5"> <?php  echo $form->textFieldRow(
                                $model['o'], 'billing_postcode',
                                array('rel' => 'tooltip', 'data-toggle' => "tooltip",
                            'data-placement' => "right",)
                        );?>
</div>
                         <div class="span5"> <?php echo $form->textFieldRow(
                                $model['o'], 'billing_state',
                                array('rel' => 'tooltip',  'data-toggle' => "tooltip",
                            'data-placement' => "right",)
                        );?>
</div>
                         <div class="span5"> <?php  echo $form->textFieldRow(
                                $model['o'], 'billing_country',
                                array('rel' => 'tooltip', 'data-toggle' => "tooltip",
                            'data-placement' => "right",)
                        );?>
</div>
                         <div class="span5"> <?php echo $form->textFieldRow(
                                $model['o'], 'payment_method',
                                array('rel' => 'tooltip', 'data-toggle' => "tooltip",
                            'data-placement' => "right",)
                        );
                        //exit;
                        ?></div>
                    </div>
                </fieldset>
  </div>
        
 
            <div class="span12">
                <fieldset class="portlet" >
                    <div class="portlet-decoration arrow-minus" onclick=" $('#hide_box_line8').slideToggle();">
                        <div class="span11"><?php echo yii::t('orders','heading_sub_title_payment_shipping_details');?> </div>
                        <div class="span1 Dev-arrow"><button class="btn btn-info arrow_main" type="button"></button> </div>
                        <div class="clearfix"></div>	
                    </div>
                    <div class="portlet-content" id="hide_box_line8">
                        <div class="span5">  <?php
                        echo $form->textFieldRow(
                                $model['o'], 'delivery_firstname',
                                array('rel' => 'tooltip', 'data-toggle' => "tooltip",
                            'data-placement' => "right",)
                        );?></div>
                        
                         <div class="span5"> <?php  echo $form->textFieldRow(
                                $model['o'], 'delivery_lastname',
                                array('rel' => 'tooltip', 'data-toggle' => "tooltip",
                            'data-placement' => "right",)
                        );?></div>
                         <div class="span5"> <?php  echo $form->textFieldRow(
                                $model['o'], 'delivery_company',
                                array('rel' => 'tooltip', 'data-toggle' => "tooltip",
                            'data-placement' => "right",)
                        );?>
</div>
                         <div class="span5"> <?php  echo $form->textFieldRow(
                                $model['o'], 'delivery_address_1',
                                array('rel' => 'tooltip', 'data-toggle' => "tooltip",
                            'data-placement' => "right",)
                        );?>
</div>
                         <div class="span5"> <?php  echo $form->textFieldRow(
                                $model['o'], 'delivery_address_2',
                                array('rel' => 'tooltip',  'data-toggle' => "tooltip",
                            'data-placement' => "right",)
                        );?>
</div>
                         <div class="span5"> <?php  echo $form->textFieldRow(
                                $model['o'], 'delivery_city',
                                array('rel' => 'tooltip',  'data-toggle' => "tooltip",
                            'data-placement' => "right",)
                        );?>
</div>
                         <div class="span5"> <?php echo $form->textFieldRow(
                                $model['o'], 'delivery_postcode',
                                array('rel' => 'tooltip',  'data-toggle' => "tooltip",
                            'data-placement' => "right",)
                        );?>
</div>
                         <div class="span5"> <?php  echo $form->textFieldRow(
                                $model['o'], 'delivery_state',
                                array('rel' => 'tooltip', 'data-toggle' => "tooltip",
                            'data-placement' => "right",)
                        );?>
</div>
                         <div class="span5"> <?php  echo $form->textFieldRow(
                                $model['o'], 'delivery_country',
                                array('rel' => 'tooltip', 'data-toggle' => "tooltip",
                            'data-placement' => "right",)
                        );?>
</div>
                         <div class="span5"> <?php  echo $form->textFieldRow(
                                $model['o'], 'shipping_method',
                                array('rel' => 'tooltip',  'data-toggle' => "tooltip",
                            'data-placement' => "right",)
                        );
                        //exit;
                        ?> </div>
                    </div>
                </fieldset>
            </div>   
      </div>
        
    </div>