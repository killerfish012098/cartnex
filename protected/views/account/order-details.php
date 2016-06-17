<div class="center-wrapper register-inner-pages"> 
    <div class="col-md-12">

<div class="heading-box"><h2><?php echo Yii::t('account', 'heading_title_history') ?><!--<div class="heading-right pull-right"><i class="glyphicon glyphicon-print"></i><?php echo Yii::t('account', 'button_print') ?> </div>--> </h2></div>
        <div class="">

            <div class="row ">
                <div class="col-md-6  design-order-line"> 
					<?php
                    $box = $this->beginWidget(
                            'bootstrap.widgets.TbBox', array('title' => Yii::t('account', 'Order Information'),
                        ));
                    ?>
                    
                    <table class="table">
                        <tr><td width="40%;"><strong><?php echo 'Order No' ?></strong></td><td>:</td><td><?php echo $model['o']['id_order']; ?></td></tr>
                        <tr><td><strong><?php echo 'Date Purchased' ?></strong></td><td>:</td><td><?php echo $model['o']['date_created']; ?></td></tr>
                        <tr><td><strong><?php echo 'Name' ?></strong></td>				<td>:</td><td><?php echo $model['o']['firstname'] . " " . $model['o']['lastname']; ?></td></tr>

                        <tr><td><strong><?php echo Yii::t('account', 'text_email') ?></strong></td>		<td>:</td><td><?php echo $model['o']['email_address']; ?></td></tr>

                        <tr><td><strong><?php echo Yii::t('account', 'text_telephone') ?></strong></td>			<td>:</td><td><?php echo $model['o']['telephone']; ?></td></tr>
                        <tr><td><strong><?php echo 'Payment Details'; ?></strong></td>	<td>:</td><td><?php echo $model['o']['billing_firstname'] . " " . $model['o']['billing_lastname'] . "," . $model['o']['billing_company'] . "," . $model['o']['billing_address_1'] . "," . $model['o']['billing_address_2'] . "," . $model['o']['billing_city'] . "," . $model['o']['billing_state'] . "," . $model['o']['billing_postcode'] . "," . $model['o']['billing_country']; ?></td></tr>
                        <tr><td><strong><?php echo 'Payment Method' ?></strong></td>				<td>:</td><td><?php echo $model['o']['payment_method']; ?></td></tr>

                    </table>
                    <?php $this->endWidget(); ?>
        				
 			 </div>



                <?php if ($model['o']['shipping_method']) { ?>
                    <div class="col-md-6 "> 
<?php
                    $box = $this->beginWidget(
                            'bootstrap.widgets.TbBox', array('title' => Yii::t('account', 'heading_title_delivery'),
                        ));
                    ?>
                        <table class="table">
                           
                            <tr>
                                <td><strong> <?php echo 'Name' ?></strong></td>	   <td>:</td>    <td> <?php echo $model['o']['delivery_firstname'] . " " . $model['o']['delivery_lastname']; ?> </td> </tr>

                            <tr>   <td><strong> <?php echo Yii::t('account', 'text_company') ?></strong></td>	   <td>:</td>    <td> <?php echo $model['o']['delivery_company']; ?> </td> </tr>
                            <tr>    <td><strong> <?php echo Yii::t('account', 'text_address') ?> </strong></td>	   <td>:</td>    <td> <?php
                                    echo (!empty($model['o']['delivery_company'])) ? $model['o']['delivery_company'] . "," : "";
                                    echo (!empty($model['o']['delivery_address_1'])) ? $model['o']['delivery_address_1'] . "," : "";
                                    echo (!empty($model['o']['delivery_address_2'])) ? $model['o']['delivery_address_2'] . ",<br />" : "<br />";
                                    echo (!empty($model['o']['delivery_city'])) ? $model['o']['delivery_city'] . "," : "";
                                    echo (!empty($model['o']['delivery_state'])) ? $model['o']['delivery_state'] . "," : "";
                                    echo (!empty($model['o']['delivery_country'])) ? $model['o']['delivery_country'] . "," : "";
                                    echo (!empty($model['o']['delivery_pincode'])) ? $model['o']['delivery_pincode'] . "," : "";
                                    ?> </td> </tr>
                            </tr>
                            <tr>   <td><strong> Shipping Method</strong></td>	   <td>:</td>    <td> <?php echo $model['o']['shipping_method']; ?> </td> </tr>	

                        </table>

  <?php $this->endWidget(); ?>
                    </div><?php } ?>

                <div class="col-md-12"> 
                    <table class="table main-order-detailes">
                        <thead>
                            <tr>
                                <th><?php echo Yii::t('account', 'column_name') ?></th>
                                <th><?php echo Yii::t('account', 'column_model') ?></th>
                                <th><?php echo Yii::t('account', 'column_quantity') ?></th>
                                <th><?php echo Yii::t('account', 'column_unit_price') ?></th>
                                <th><?php echo Yii::t('account', 'column_total') ?></th>
                            </tr>
                        </thead>
                        <?php 
						echo "value of ".strtotime(date('Y') . '-' . date('m') . '-' . date('d'));
						foreach ($model['op'] as $product): ?>
                            <tbody id="rowProduct-<?php echo $product['id_product']; ?>">
                                <tr>
                                    <td><p><?php
                                            echo $product['name'];
                                            foreach ($product['options'] as $option):
                                                echo "<p> <strong class='design-orde'>" . $option[name] . ":" . $option[value]."</strong></p>";
                                            endforeach;

                                            if ($product['has_download']):
												$allowDownload=(strtotime(date('Y').'-'.date('m').'-'.date('d'))<strtotime($product[download_expiry_date])) && ($model['o']['id_order_status']==Yii::app()->config->getData('CONFIG_WEBSITE_COMPLETE_ORDER_STATUS')) && ($product[download_remaining_count]>0)?1:0;
												$downloadLink=$allowDownload==1?"<a href='".$this->createUrl('account/orderdownload',array('opid'=>$product['id_order_product'],'id'=>$model['o']['id_order'],'type'=>'download'))."'>[Download]</a>":"";
													
                                                echo "<p><strong class='design-orde'>File : " . $product['download_filename'] . "  </strong> <strong class='design-orde'>Remaining : " . $product[download_remaining_count] . " </strong><strong class='design-orde'><b>Expiry Date</b> " . $product[download_expiry_date].$downloadLink."  </strong></p>";
                                            endif;
                                            ?></td>
                                    <td><?php echo $product['model']; ?></td>
                                    <td><?php echo $product['quantity']; ?></td>
                                    <td><strong><?php echo Yii::app()->currency->format($product['unit_price'], $model['o']['currency'], $model['o']['currency_value']); ?></strong></td>
                                    <td><strong><?php echo Yii::app()->currency->format($product['total'], $model['o']['currency'], $model['o']['currency_value']); ?></strong></td>
                                </tr>
                            </tbody>
                        <?php endforeach; ?>


                        <?php foreach ($model['ot'] as $orderTotal): ?>
                            <tbody id="total">
                                <tr>
                                    <td colspan='4' class="text-right-dng"><h2 class="total-color-dis"><?php echo $orderTotal['title']; ?></h2></td>
                                    <td><h2 class="total-color-dis"><?php echo $orderTotal['text']; ?></h2></td>
                                </tr>
                            </tbody>
                        <?php endforeach; ?> 
                    </table>
                </div>

            </div>     
            <?php
                    $box = $this->beginWidget(
                            'bootstrap.widgets.TbBox', array('title' => Yii::t('account', 'Order History'),
                        ));
                    ?>
                       <h2></h2>
            <table class="list table main-order-detailes">
                <thead>
                    <tr >
                        <td class="left" width="20%"><strong>Date Added</strong></td>
                        <td class="left" width="40%"><strong>Status</strong></td>
                        <td class="left" width="40%"><strong>Comment</strong></td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['order_history'] as $history) { ?>
                        <tr>
                            <td class="left" width="32%"><?php echo $history['date_created']; ?></td>
                            <td class="left" width="32%"><?php echo $history['order_status_name']; ?></td>
                            <td class="left" width="32%"><?php echo $history['message']; ?></td>
                        </tr><?php } ?>
                </tbody>
            </table>
            
  <?php $this->endWidget(); ?>
            <div class=""><img src="" alt="" title="" /></div>
        </div>
    </div>
</div>