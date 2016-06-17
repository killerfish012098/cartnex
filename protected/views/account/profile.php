
<div class="center-wrapper register-inner-pages"> 
<div class="col-md-12">

<div class="heading-box"><h2><?php echo  Yii::t('account','heading_title_profile')?></h2></div>

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
	<div class="col-md-12"> 
    
		<table class="table form-design-main">
				<?php echo $form->hiddenField($model,'id_customer',array('class'=>'form-control','placeholder'=>'Please enter first name','value'=>Yii::app()->session['user_id'])); ?>
			  
				<tr> <td>*<?php echo  Yii::t('account','entry_firstname')?></td> <td>:</td> <td>
					<?php echo $form->textField($model,'firstname',array('class'=>'form-control')); ?>
					<?php echo $form->error($model,'firstname',array("style"=>'position:relative')); ?></td>
                    
                    <td>*<?php echo  Yii::t('account','entry_lastname')?></td> <td>:</td> <td> <?php echo $form->textField($model,'lastname',array('class'=>'form-control')); ?>
					<?php echo $form->error($model,'lastname',array("style"=>'position:relative')); ?></td>
				</tr>
			 
			  
				<tr> <td>*<?php echo  Yii::t('account','entry_telephone')?></td> <td>:</td> <td> <?php echo $form->textField($model,'telephone',array('class'=>'form-control')); ?>
					<?php echo $form->error($model,'telephone',array("style"=>'position:relative')); ?></td>
                    
                    <td><?php echo  Yii::t('account','entry_email')?></td> <td>:</td> <td> <?php echo $form->textField($model,'email',array('class'=>'form-control','readonly'=>true,)); ?>
					<?php echo $form->error($model,'email',array("style"=>'position:relative')); ?></td>
				</tr>
			

			  
				<tr> 
				 <td><?php echo  Yii::t('account','entry_password')?></td> <td>:</td> <td> <?php echo $form->passwordField($model,'password',array('class'=>'form-control','value'=>'')); ?>
					<?php echo $form->error($model,'password',array("style"=>'position:relative')); ?></td>
				<td><?php echo  Yii::t('account','entry_confirm')?></td> <td>:</td> <td> <?php echo $form->passwordField($model,'confirm',array('class'=>'form-control')); ?>
					<?php echo $form->error($model,'confirm',array("style"=>'position:relative')); ?></td>
                    		</tr>

				
				<tr>
				<td>*<?php echo  Yii::t('account','entry_gender')?></td> <td>:</td> <td> <?php echo  $form->radioButtonList($model,'gender',array('1'=>'Male','0'=>'Female')); ?><?php echo $form->error($model,'gender',array("style"=>'position:relative')); ?></td>
                <td>*<?php echo  Yii::t('account','entry_newsletter')?></td> <td>:</td> <td> <?php echo  $form->radioButtonList($model,'newsletter',array('1'=>'Subscribe','0'=>'UnSubscribe')); ?><?php echo $form->error($model,'newsletter',array("style"=>'position:relative')); ?></td>
				</tr>
				<tr> 
				<td> </td> <td colspan="4"></td> 
				<td  > <?php echo CHtml::submitButton(Yii::t('common','button_save'), array('class' => 'btn btn-inverse pull-right')); ?> </td>
				</tr>
		</table>
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
			url: "<?php echo Yii::app()->baseUrl;?>/index.php/account/setdefaultaddress",
			data: "id_customer_address="+$id_customer_address,
			complete: function(data){
				if(data.responseText==1){
			        $("#status-address-list").html("<span color='green'>Default Address saved successfully!! </span>");
				}else{
					 $("#status-address-list").html("<span color='red'>Default Address failed to save !! </span>");
					 return false;
				}
	        }
		});
}
function deleteAddress($id_customer_address){
$.ajax({
			type:"POST",
			url: "<?php echo Yii::app()->baseUrl;?>/index.php/account/deleteaddress",
			data: "id_customer_address="+$id_customer_address,
			complete: function(data){
				if(data.responseText=='2'){
			        $("#status-address-list").html("<span color='green'>Please remove the default address position then apply Delete Address!! </span>");
				}else if(data.responseText=='1'){
					$("#address_list_"+$id_customer_address).remove();
			        $("#status-address-list").html("<span color='green'>Address removed successfully!! </span>");
				}else{
					 $("#status-address-list").html("<span color='red'>Address fail to remove!! </span>");
					 return false;
				}
	        }
		});

}
$("#CustomerAddress_id_country").change(function(){
	$.ajax({
			type:"POST",
			url: "<?php echo Yii::app()->baseUrl;?>/index.php/account/getstatedependencylist",
			data: "country_id="+$("#CustomerAddress_id_country").val(),
			complete: function(data){
			        $("#CustomerAddress_id_state").html(data.responseText);
			}
		});
});
</script>
