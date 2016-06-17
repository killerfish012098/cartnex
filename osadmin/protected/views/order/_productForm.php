
<div class="row-fluid">
    <div class="tab-pane active" id="Information">

            <div class="span12">
                <fieldset class="portlet " >
                    <div class="portlet-decoration arrow-minus" onclick=" $('#hide_box_line12').slideToggle();">
                        <div class="span11"><?php echo Yii::t('orders','heading_sub_title_product');?> </div>
                        <div class="span1 Dev-arrow"><button class="btn btn-info arrow_main"  type="button"></button> </div>
                        <div class="clearfix"></div>	
                    </div>
                    <div class="portlet-content" id="hide_box_line12">
                        <table class="table">
                            <thead>
                                    <tr>
                                       <th><?php echo Yii::t('orders','entry_product');?></th>
                                       <th><?php echo Yii::t('orders','entry_model');?></th>
                                       <th><?php echo Yii::t('orders','entry_quantity');?></th>
                                       <th><?php echo Yii::t('orders','entry_unit_price');?></th>
                                       <th><?php echo Yii::t('orders','entry_total');?></th>
                                    </tr>
                            </thead>
                            <?php 
                            /*echo '<pre>';
                            print_r($data);
                            exit;*/
                            foreach($model['op'] as $product):?>
                            <tbody id="rowProduct-<?php echo $product->id_product;?>">
                                <tr>
                                       <td width="22%"><?php echo $product->name;
                                       foreach($data['product'][$product->id_order_product]['option'] as $option):
                                           echo "<br/>".$option[name].":".$option[value];
                                       endforeach;
                                       
                                       if(isset($data[download][$product->id_order_product])):
                                        echo "<br/><b>File</b> : ".$data[download][$product->id_order_product]['download_filename']." <br/> <b>Remaining</b> : ".$data[download][$product->id_order_product][download_remaining_count]." <br/><b>Expiry Date</b> : ".$data[download][$product->id_order_product][download_expiry_date];
                                       endif;
                                       ?></td>
                                       <td width="15%"><?php echo $product->model;?></td>
                                       <td width="15%"><?php echo $product->quantity;?></td>
                                       <td width="22%"><?php echo $data['product'][$product->id_order_product]['unit_price'];?></td>
                                       <td width="9%"><?php echo $data['product'][$product->id_order_product]['total'];?></td>
                                </tr>
                            </tbody>
                            <?php endforeach;?>
                            <?php foreach(OrderTotal::getOrderTotal(array('condition'=>'id_order='.$id,'order'=>'sort_order asc')) as $orderTotal):?>
                            <tbody id="total">
                                <tr>
                                       <td colspan='4' class="right-text font-title-price"><?php echo $orderTotal->title;?></td>
                                       <td class="font-title-price"><?php echo $orderTotal->text;?></td>
                                </tr>
                            </tbody>
                            <?php endforeach;?>
                            <tfoot>
                                <?php //foreach(OrderHistory::getOrderHistory(array('condition'=>'id_order='.$id,'order'=>'date_created desc')) as $history):?>
                            </tfoot>
                        </table> 
            </div>
                </fieldset>
            </div>   
    </div>
</div>
   