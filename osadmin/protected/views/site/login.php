

<div class="main_login_bg">
	<div class="page-header">
	<h1><img src="<?php echo Yii::app()->baseUrl?>/img/Logo-big.png" alt="" title="" /></h1>
    </div>
<div class="row-fluid">
	<div class="span5 offset3">
<?php
	$this->beginWidget('zii.widgets.CPortlet', array(
		'title'=>Yii::t('login','heading_title'),//"Sigin in",
	));
	
?>

     <?php 
	 $form=$this->beginWidget('CActiveForm', array(
        'id'=>'login-form',
        'enableClientValidation'=>true,

        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
		
    )); 
	 ?>
    <div class="form">
   		 <div class="span12 offset3">
          <div class="row login_main">

            <?php echo $form->textField($model,'username', array('autofocus'=>'autofocus','hint'=>"hello",'id'=>'input-small', 'placeholder'=>Yii::t('login','entry_username')) ); ?>
            <i class="icon-user loging_page"></i>
            <?php echo $form->error($model,'username'); ?>
        </div>
    
        <div class="row login_main">
  
            <?php echo $form->passwordField($model,'password', array('id'=>'input-small', 'placeholder'=>Yii::t('login','entry_password'))); ?>
             <i class="icon-lock loging_page"></i>
            <?php echo $form->error($model,'password'); ?>
           
        </div>
    
    <div class="two_left_right">
        <div class="row rememberMe">
       <?php //echo $form->label($model,'Forgot password'); 
	   
	   ?>
	   <?php echo CHtml::link(Yii::t('login','text_forgotten'),array('site/forgotpassword')); ?>

        </div>
        <div class="row buttons">
            <?php echo CHtml::submitButton(Yii::t('login','button_login'),array('class'=>'btn btn-info')); ?>
        </div>
        
        </div>
    
    <?php $this->endWidget(); ?>
    </div><!-- form -->

<?php $this->endWidget();?>
<div class="clearfix"></div>
    </div>
	 <div class="clearfix"></div>
		</div>
	</div>
</div>