<div class="center-wrapper login-inner-pages"> 
<div class="heading-box"><h2><?php echo  Yii::t('account','heading_title_login')?></h2></div>
<div class="row">
<div class="col-md-6">
<p><strong><?php echo  Yii::t('account','text_new_customer')?></strong></p>

<p><?php echo  Yii::t('account','text_register')?></p>
<p><?php echo  Yii::t('account','text_register_account')?></p>

<p><?php $this->widget('bootstrap.widgets.TbButton', array('type' => 'inverse','size' => 'large',  'label' => Yii::t('account','button_signup'),)); ?>  <span class="large-or"><?php echo  Yii::t('common','text_or')?></span>
</p>



</div>

<div class="col-md-6">
<div class="form">

		<?php 
		$form=$this->beginWidget('CActiveForm', array(
			'id'=>'login-form',
			'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnSubmit'=>true,
			),
		)); ?>

		<p><strong><?php echo  Yii::t('account','text_returning_customer')?></strong></p>
		<p class="note"><?php echo  Yii::t('account','text_i_am_returning_customer')?></p>
		<?php echo Yii::app()->flash->getFlash()?>
		<div class="mailid-div">
			<?php /*?><?php echo $form->labelEx($model,'username'); ?><?php */?>
			<?php echo $form->textField($model,'username', array( 'placeholder'=>Yii::t('account','entry_email'))); ?>
			<?php echo $form->error($model,'username'); ?>
		</div>

		<div class="mailid-div">
<?php /*?>		<?php echo $form->labelEx($model,'password'); ?> <?php */?>
		<div class="col-md-9 login-div-mains"><?php echo $form->passwordField($model,'password',  array( 'placeholder'=>Yii::t('account','entry_password'))); ?>
		<?php echo $form->error($model,'password'); ?></div>
   <div class="col-md-3 login-div-mains"> <span class="mailid-div buttons">
		<?php echo CHtml::submitButton(Yii::t('account','text_login'), array('class' => 'btn btn-inverse')); ?>
 	</span></div>
		<div class="clear"></div>
	</div>

	<!--<div class="mailid-div mind-div">
		<?php //echo $form->checkBox($model,'rememberMe'); ?>
		<?php //echo $form->label($model,'rememberMe'); ?>
	</div>-->
    
    
	<div class="mailid-div mind-div pull-right">
		<?php echo CHtml::link(Yii::t('account','text_forgotten'), $this->createAbsoluteUrl('account/forgotpassword')); ?>
	</div>



<?php $this->endWidget(); ?>
</div><!-- form -->
</div>
   </div>  
   
  <div class="clearfix" ></div>
   </div>
