  <div class="center-wrapper register-inner-pages"> 
    <div class="col-md-12">
	<div class="heading-box"><h2><?php echo Yii::t('account','heading_title_forgotpassword');?></h2></div>
	<div class="forgot-div-main row">
	<h5><?php echo Yii::t('account','text_forgot_email');?></h5>
		<div class="row col-md-12 forgot-div-main-padding">
		<div class=" col-md-9">
		<?php 
		$form=$this->beginWidget('CActiveForm', array(
			'id'=>'forgot-password-form',
			'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnSubmit'=>true,
			),
		)); ?>

		<?php echo $form->textField($model,'email', array('class'=>"forgot-div-main form-control", 'placeholder'=>Yii::t('account','entry_forgot_email'))); ?>

		<?php echo $form->error($model,'email'); ?></div> <?php echo CHtml::submitButton(Yii::t('account','button_send'), array('class' => 'btn  btn-inverse')); ?> 

		<?php echo CHtml::Button(Yii::t('account','button_back'), array('class' => 'btn btn-inverse','onclick'=>'window.history.back();')); ?>
		

		<?php $this->endWidget(); ?>
		</div>
     </div>
    </div>
  </div>