<div class="col-md-4 ">
<div class="effect8">	
  <table class="table">
    <tr>
    <td width="45%"><strong><?php echo Yii::t('account','text_order_id')?></strong></td>
    <td>:</td>
    <td><?php echo  $data['id_order']; ?></td>
    </tr>
    <tr><td><strong><?php echo Yii::t('account','text_status')?></strong></td> <td>:</td> <td><?php echo  $data['order_status_name']; ?></td> </tr>
    <tr><td><strong><?php echo Yii::t('account','text_date_created')?></strong></td><td>:</td><td><?php echo  $data['date_created']; ?></td></tr>
    <tr><td><strong><?php echo Yii::t('account','text_amount')?></strong></td><td>:</td><td><?php echo  Yii::app()->currency->format($data['total'],$data['currency'],$data['currency_value']); ?></td></tr>
   
    <tr><td><strong><?php echo Yii::t('account','text_shipping_address')?></strong></td><td></td><td></td></tr>
    
    <tr>
    <td colspan="3"> 
	<?php 
	echo (!empty($data['delivery_firstname'])) ? $data['delivery_firstname']." " : "";
	echo (!empty($data['delivery_lastname'])) ? $data['delivery_lastname'].",<br />" : "<br />";
	echo (!empty($data['delivery_company'])) ? $data['delivery_company']."," : "";
	echo (!empty($data['delivery_address_1'])) ? $data['delivery_address_1']."," : "";
	echo (!empty($data['delivery_address_2'])) ? $data['delivery_address_2'].",<br />" : "<br />";
	echo (!empty($data['delivery_city'])) ? $data['delivery_city']."," : "";
	echo (!empty($data['delivery_state'])) ? $data['delivery_state']."," : "";
	echo (!empty($data['delivery_country'])) ? $data['delivery_country']."," : "";
	echo (!empty($data['delivery_postcode'])) ? $data['delivery_postcode']."," : "";
	?>
	</td>
    </tr>
    
    <tr><td colspan="3"><?php $this->widget('bootstrap.widgets.TbButton', array('type' => 'primary','size' => 'large', 'label' => Yii::t('account','button_order_details'), 'htmlOptions'=>array('class'=>'addtocart', 'href' => $this->createAbsoluteUrl('account/orderdetails',array('id'=>$data['id_order']))), )); ?></td></tr>
    
    </table>
    </div>

</div>