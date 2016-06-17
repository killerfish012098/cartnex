<div class=" checkout_main_div">
    <div class="col-md-12 border-line-div">
        <div class="col-md-7">
            <p><strong><?php echo Yii::t('account', 'text_new_customer'); ?></strong></p>
            <div class="row">
                <div class="col-md-5"><a href="<?php echo $this->createUrl("account/register"); ?>" class="btn btn-inverse"><?php echo Yii::t('account', 'text_register'); ?></a> </div>
                <?php if($data['guestCheckout']){?>
				<div class="col-md-5"> <a class="btn btn-inverse" href="#" id="button_guest"><?php echo Yii::t('account', 'text_guest'); ?></a> </div><?php }?>
            </div>
            <br />
            <p><?php echo Yii::t('account', 'text_register_account'); ?></p>
            <!--<div class="social-wrap a">
                <button id="facebook"><?php echo Yii::t('account', 'text_login_facebook'); ?></button>
                <button id="googleplus"><?php echo Yii::t('account', 'text_login_google'); ?></button>
            </div>-->
        </div>
        <div class="col-md-5">
            <p><strong><?php echo Yii::t('account', 'text_returning_customer'); ?></strong></p><p><?php echo Yii::t('account', 'text_i_am_returning_customer'); ?></p>
            <?php
            /*Yii::app()->flash->getFlash();
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'login-form',
                'enableClientValidation' => true,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
            ));*/
            ?>
            <div class="mailid-div">
                <?php 
                      echo CHtml::textField('email', array('class' => 'form-control', 'placeholder' => Yii::t('account', 'entry_email')));
                      //echo $form->textField($model, 'email', array('class' => 'form-control', 'placeholder' => Yii::t('account', 'entry_email'))); ?>
                <?php //echo $form->error($model, 'email'); ?>
                
            </div>   
            <div class="mailid-div">
                <?php 
                echo CHtml::passwordField('password', array('class' => 'form-control', 'placeholder' => Yii::t('account', 'entry_password')));
//echo $form->passwordField($model, 'password', array('class' => 'form-control', 'placeholder' => Yii::t('account', 'entry_password'))); ?>
                <?php //echo $form->error($model, 'password'); ?>
            </div>        
            <p><?php echo CHtml::submitButton('Login', array('name' => 'button-login','id' => 'button-login','class' => 'btn  btn-inverse')); ?>  <?php echo CHtml::link('Forgot Password', $this->createAbsoluteUrl('account/forgotpassword')); ?> </p> 
            <?php //$this->endWidget(); ?>       
        </div>
    </div>

</div>