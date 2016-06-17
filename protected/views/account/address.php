  <div class="center-wrapper register-inner-pages"> 
    <div class="col-md-12">
  
<div class="heading-box"><h2><?php echo Yii::t('account','heading_title_addaddress');?></h2></div>
<div class="">

<?php 
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

<div class="row ">
 <div class="col-md-6"> 
    
  
  <table class="table form-design-main">
  <tr> <td>*<?php echo Yii::t('account','entry_firstname');?></td> <td>:</td> <td><?php echo $form->hiddenField($model,'id_customer',array('class'=>'form-control','value'=>Yii::app()->session['user_id'])); ?>
  <?php echo $form->textField($model,'firstname',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'firstname'); ?></td>
  </tr>
  
    <tr> <td>*<?php echo Yii::t('account','entry_lastname');?></td> <td>:</td> <td> <?php echo $form->textField($model,'lastname',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'lastname'); ?></td>
  </tr>
  
  
    <tr> <td>*<?php echo Yii::t('account','entry_telephone');?></td> <td>:</td> <td> <?php echo $form->textField($model,'telephone',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'telephone'); ?></td>
  </tr>
  
  <tr> <td>*<?php echo Yii::t('account','entry_address1');?></td> <td>:</td> <td> <?php echo $form->textArea($model,'address_1',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'address_1'); ?></td>
  </tr>
  
  <tr> <td><?php echo Yii::t('account','entry_address2');?></td> <td>:</td> <td> <?php echo $form->textArea($model,'address_2',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'address_2'); ?></td>
  </tr>  
  
    <tr> <td><?php echo Yii::t('account','entry_company');?></td> <td>:</td> <td> <?php echo $form->textField($model,'company',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'company'); ?></td>
  </tr>  
  
    <tr> <td>*<?php echo Yii::t('account','entry_city');?></td> <td>:</td> <td> <?php echo $form->textField($model,'city',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'city'); ?></td>
  </tr>
  <tr> <td>*<?php echo Yii::t('account','entry_country');?></td> <td>:</td> <td> <?php $list_country=CHtml::listData($data['country'],'id_country','name');
   echo $form->dropDownList($model,'id_country', $list_country,array('prompt'=>'--Select Country--','class'=>'form-control')); ?>
		<?php echo $form->error($model,'id_country'); ?></td>
  </tr>
   <tr> <td>*<?php echo Yii::t('account','entry_state');?></td> <td>:</td> <td> <?php 
   $list_state=CHtml::listData($data['state'],'id_state','name');
   echo $form->dropDownList($model,'id_state', $list_state,array('prompt'=>'--Select State--','class'=>'form-control')); ?>
		<?php echo $form->error($model,'id_state'); ?></td>
  </tr>
  
     
       <tr> <td>*<?php echo Yii::t('account','entry_postcode');?></td> <td>:</td> <td> <?php echo $form->textField($model,'postcode',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'postcode'); ?></td>
</tr>
      <tr> 
       <td> </td> <td></td> 
       <td > <?php echo CHtml::submitButton(yii::t('common','button_save'), array('class' => 'btn btn-inverse')); ?> </td>
</tr>

  
  </table>
  
    </div>
  
      <div class="col-md-6" style="height: 500px;overflow-y: scroll;" id="address-list"> 
      
<?php foreach ($data['address_list'] as $addresslist){?>
<div id="address_list_<?php echo $addresslist['id_customer_address'];?>" class="address-list-design">
   <p><?php 
	   echo (!empty($addresslist['firstname'])) ? $addresslist['firstname'].", " : "";
	   echo (!empty($addresslist['lastname'])) ? $addresslist['lastname'].", " : "";
	   echo (!empty($addresslist['address_1'])) ? $addresslist['address_1'].", " : "";
	   echo (!empty($addresslist['address_2'])) ? $addresslist['address_2'].", " : "";
	   echo (!empty($addresslist['city'])) ? $addresslist['city'].", " : "";
	   echo (!empty($addresslist['id_state'])) ? $addresslist['state'].", " : "";
	   echo (!empty($addresslist['id_country'])) ? $addresslist['country'].", " : "";
	   echo (!empty($addresslist['postcode'])) ? $addresslist['postcode'].", " : "";
	   echo (!empty($addresslist['telephone'])) ? $addresslist['telephone'].". " : "";  
	?></p>
    <div class="row address-top-line" ><div class="col-md-7"><input type="radio" name="default_address" id="default_address_<?php echo $addresslist['id_customer_address'];?>" onclick="return setAddress('<?php echo $addresslist['id_customer_address'];?>')" <?php if(Yii::app()->session['user_id_customer_address_default']==$addresslist['id_customer_address']){?> checked="checked"<?php } ?>/> 
	<?php echo  Yii::t('account','text_default_address')?></div> <div class="col-md-4 "> <?php $this->widget('bootstrap.widgets.TbButton', array('type' => 'danger','size' => 'large', 'label' => Yii::t('account','text_delete_address'), 'htmlOptions'=>array('class'=>'','onclick'=>'return deleteAddress('.$addresslist['id_customer_address'].')'), )); ?> </div></div></div>
    <?php } ?>
    </div>
    </div>
    <?php $this->endWidget(); ?>
<div class=""><img src="" alt="" title="" /></div>
</div>
  </div>

   
   </div>
  

<script type="text/javascript">
function setAddress($id_customer_address){
$.ajax({
			type:"POST",
			url: "<?php echo $this->createUrl('account/setdefaultaddress');?>",
			data: "id_customer_address="+$id_customer_address,
			complete: function(data){
				if(data.responseText==1){
			        $("#notification").html('<?php echo Yii::t('account','text_default_save_success')?>');
				}else{
					 $("#notification").html('<?php echo Yii::t('account','text_default_save_fail')?>');
					 return false;
				}
	        }
		});
}
function deleteAddress($id_customer_address){
$.ajax({
			type:"POST",
			url: "<?php echo $this->createUrl('account/deleteaddress');?>",
			data: "id_customer_address="+$id_customer_address,
			complete: function(data){
				if(data.responseText=='2'){
			        //$("#notification").html('<?php echo Yii::t('account','text_default_remove_warning')?>');

$("#notification").html('<?php echo Yii::t('account','text_default_remove_warning')?>');}else if(data.responseText=='1'){
					$("#address_list_"+$id_customer_address).remove();
			        $("#notification").html('<?php echo Yii::t('account','text_default_remove_success')?>');
				}else{
					 $("#notification").html('<?php echo Yii::t('account','text_default_remove_fail')?>');
					 return false;
				}
	        }
		});

}
$("#AddressForm_id_country").change(function(){
	$.ajax({
			type:"POST",
			url: "<?php echo $this->createUrl('account/getstatedependencylist');?>",
			data: "id_country="+$("#AddressForm_id_country").val(),
			complete: function(data){
			        $("#AddressForm_id_state").html(data.responseText);
                                //$("#notification").html(data.responseText);
			}
		});
});
</script>