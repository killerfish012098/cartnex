<?php $orderStatusDetails=Yii::app()->config->getData('orderStatusDetails');?>
<div class="row-fluid nav_main">
    <div class="span2 fluid_span"><?php echo yii::t('orders','entry_order_id');?><span>  <?php echo $model['o']->id_order;?> </span></div>
    <div class="span2 fluid_span"><?php echo yii::t('orders','entry_invoice');?> <span> <?php echo $model['o']->invoice_prefix.$model['o']->invoice_no;?> </span></div>
    <div class="span2 fluid_span"><?php echo yii::t('orders','entry_date_ordered');?><span> <?php echo $model['o']->date_created;?> </span></div>
    <div class="span2 fluid_span"><?php echo yii::t('orders','entry_amount');?><span> <?php echo $data['order']['total'];?> </span>	</div>
    <div class="span2 fluid_span"><?php echo yii::t('orders','entry_status');?><span>  <?php echo '<span style="background-color:'.$orderStatusDetails[$model['o']->id_order_status].';color:white" class="label color_field">'.$model['o']->order_status_name.'</span>';?> </span></div>
    <div class="span2 fluid_span"><?php echo yii::t('orders','entry_last_updated');?><span>  <?php echo $model['o']->date_modified;?> </span></div>
</div>
<div class="row-fluid">
    <div class="tab-pane active" id="Information">
    
            <div class="span12">
                <fieldset class="portlet " >
                    <div class="portlet-decoration arrow-minus" onclick=" $('#hide_box_line2').slideToggle();">
                        <div class="span11"><?php echo yii::t('orders','heading_sub_title');?> </div>
                        <div class="span1 Dev-arrow"><button class="btn btn-info arrow_main" type="button"></button> </div>
                        <div class="clearfix"></div>	
                    </div>
                    <div class="portlet-content" id="hide_box_line2">
                        <div class="span5">  <?php
                        echo $form->textFieldRow(
                                $model['o'], 'firstname',
                                array('rel' => 'tooltip', 'data-toggle' => "tooltip",
                            'data-placement' => "right",'disabled'=>true)
                        );?> </div>
                         <div class="span5"> <?php 
						echo $form->textFieldRow(
                                $model['o'], 'lastname',
                                array('rel' => 'tooltip',  'data-toggle' => "tooltip",
                            'data-placement' => "right",)
                        );?> </div>
                         <div class="span5"> <?php 

                        echo $form->textFieldRow(
                                $model['o'], 'email_address',
                                array('rel' => 'tooltip', 'data-toggle' => "tooltip",
                            'data-placement' => "right",)
                        );?> </div>
                         <div class="span5"> <?php 

                        echo $form->textFieldRow(
                                $model['o'], 'customer_group',
                                array('rel' => 'tooltip','data-toggle' => "tooltip",
                            'data-placement' => "right",)
                        );?> </div>
                         <div class="span5"> <?php 

                        echo $form->textFieldRow(
                                $model['o'], 'telephone',
                                array('rel' => 'tooltip', 'data-toggle' => "tooltip",
                            'data-placement' => "right",)
                        );?> </div>

                         <div class="span5"> <?php 


                        echo $form->textFieldRow(
                                $model['o'], 'message',
                                array('rel' => 'tooltip',  'data-toggle' => "tooltip",
                            'data-placement' => "right",)
                        );?> </div>
                      
                    </div>
                </fieldset>
            </div>   
  
            <div class="span12">
                <fieldset class="portlet " >
                   <div class="portlet-decoration arrow-minus" onclick=" $('#hide_box_line1').slideToggle();">
                        <div class="span11"><?php echo yii::t('orders','heading_sub_title_payment_update_status');?> </div>
                        <div class="span1 Dev-arrow"><button class="btn btn-info arrow_main" type="button"></button> </div>
                        <div class="clearfix"></div>	
                    </div>
                    <div class="portlet-content" id="hide_box_line1">
                    <table class="table uploading-status" border='0'>
                            <thead>
                                    <tr>
                                       <th><?php echo yii::t('orders','entry_date');?></th>
                                       <th><?php echo yii::t('orders','entry_status');?></th>
                                       <th><?php echo yii::t('orders','entry_comment');?></th>
                                       <th><?php echo yii::t('orders','entry_notified');?></th>
                                    </tr>
                            </thead>
                            <tbody id="order_status">
                                <?php foreach(OrderHistory::getOrderHistory(array('condition'=>'id_order='.$id,'order'=>'date_created desc')) as $history):?>
                                <tr>
                                       <td><?php echo $history->date_created;?></td>
                                       <td><?php echo '<span style="background-color:'.$orderStatusDetails[$history->id_order_status].';color:white" class="label color_field">'.$history->order_status_name.'</span>';?></td>
                                       <td><?php echo $history->message;?></td>
                                       <td><?php echo $history->notified_by_customer=='1'?Yii::t('common','text_yes'):Yii::t('common','text_no');?></td>
                                </tr>
                                <?php endforeach;?>    
                            </tbody>
                    <tfoot>
                    </tfoot>
                    </table> 
                    <div class="portlet-content" id="hide_box_line3">
                        <div class="span5"> <?php
                        echo $form->dropDownListRow($model['oh'],
                                'order_status_name',
                                CHtml::listData($data['order_status'],
                                        'id', 'name')); ?>
</div>
                         <div class="span5"> <?php  echo $form->checkboxRow(
                                $model['oh'], 'notified_by_customer',
                                array('rel' => 'tooltip', 'data-toggle' => "tooltip",
                            'data-placement' => "right",)
                        );?>
</div>
                         <div class="span11"> <?php  echo $form->textAreaRow(
                                $model['oh'], 'message',
                                array('rel' => 'tooltip',  'data-toggle' => "tooltip",
                            'data-placement' => "right",)
                        );?>
</div>
                         <div class="span5"> <?php echo CHtml::ajaxButton ("Update Status",
                              $this->createUrl('order/updateStatus',array('id'=>$id)), 
                              array('dataType' => 'text','type'=>'post','update' => '#order_status'));
                        ?></div>
                    </div>
                </fieldset>
            </div>   
    </div>
</div>