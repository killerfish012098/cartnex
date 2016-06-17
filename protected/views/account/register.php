<div class="center-wrapper register-inner-pages"> 
    <div class="col-md-12">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'login-form',
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
            ),
        ));
        ?>
        <div class="col-md-6">
            <div class="heading-box"><h2><?php echo Yii::t('account', 'heading_title_register'); ?> <span class="pull-right col-md-6 heading_title_sing"><?php echo Yii::t('account', 'text_account_already', array('{login}' => $this->createUrl('account/login'))) ?></a></span> </h2></div>

            <div class="body-div-main register-div-main">
                <?php echo $form->errorSummary($model); ?>
                <div class="col-md-12">
                    <div class="col-md-3"><?php echo Yii::t('account', 'entry_name') ?></div>
                    <div class="col-md-9">
                        <?php echo $form->textField($model, 'firstname', array('class' => 'form-control', 'placeholder' => Yii::t('account', 'entry_firstname'))); ?>
                        <?php echo $form->error($model, 'firstname'); ?>  


                    </div>
                </div>

                <div class="col-md-12">
                    <div class="col-md-3"><?php echo Yii::t('account', 'entry_lastname') ?></div>
                    <div class="col-md-9">
                        <?php echo $form->textField($model, 'lastname', array('class' => 'form-control last-child', 'placeholder' => Yii::t('account', 'entry_lastname'))); ?>
                        <?php echo $form->error($model, 'lastname'); ?>
                        <div id="status-msg"></div>
                    </div>
                </div>



                <div class="col-md-12">
                    <div class="col-md-3"><?php echo Yii::t('account', 'entry_email') ?></div>
                    <div class="col-md-9">
                        <?php echo $form->textField($model, 'email', array('onchange' => 'checkEmail(this.value)', 'class' => 'form-control', 'placeholder' => Yii::t('account', 'entry_email'))); ?>
                        <?php echo $form->error($model, 'email'); ?> 
                        <div id="status-msg"></div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="col-md-3"><?php echo Yii::t('account', 'entry_telephone') ?></div>
                    <div class="col-md-9">
                        <?php echo $form->textField($model, 'telephone', array('class' => 'form-control', 'placeholder' => Yii::t('account', 'entry_telephone'))); ?>
                        <?php echo $form->error($model, 'telephone'); ?> 
                    </div>
                </div>


                <div class="col-md-12">
                    <div class="col-md-3"><?php echo Yii::t('account', 'entry_password') ?></div>
                    <div class="col-md-9">
                        <?php echo $form->passwordField($model, 'password', array('class' => 'form-control', 'placeholder' => Yii::t('account', 'entry_password'))); ?>
                        <?php echo $form->error($model, 'password'); ?> 

                    </div>
                </div>

                <div class="col-md-12">
                    <div class="col-md-3"><?php echo Yii::t('account', 'entry_confirm') ?></div>
                    <div class="col-md-9">
                        <?php echo $form->passwordField($model, 'confirm', array('class' => 'form-control', 'placeholder' => Yii::t('account', 'entry_confirm'))); ?>
                        <?php echo $form->error($model, 'confirm'); ?> 
                        <div id="status-msg"></div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="col-md-3"><?php echo Yii::t('account', 'entry_gender') ?></div>
                    <div class="col-md-9">
                        <?php $model->gender = 1;
                        echo $form->radioButtonList($model, 'gender', array('1' => Yii::t('account', 'text_male'), '0' => Yii::t('account', 'text_female')), array('separator' => ''));
                        ?>
                    </div>
                </div>

                <div class="col-md-12 register-div-newsletter">
                    <div class="col-md-6"><?php echo Yii::t('account', 'entry_newsletter') ?></div>
                    <div class="col-md-4">
                        <?php $model->newsletter = 1;
                        echo $form->radioButtonList($model, 'newsletter', array('1' => Yii::t('common', 'text_yes'), '0' => Yii::t('common', 'text_no')), array('separator' => ''));
                        ?>

                    </div>
                </div>

                        <?php if ($data['acknowledgement']) { ?>
                    <div class="col-md-12">
                        <p><?php echo $data['text_agree']; ?>
    <?php echo $form->checkBox($model, 'acknowledgement', array('value' => '1', 'uncheckValue' => '0')); ?>
                    <?php echo $form->error($model, 'acknowledgement'); ?> 
                        </p>
                    </div>
                    <?php } ?>

                <div class="col-md-12">
<?php echo CHtml::submitButton(Yii::t('account', 'text_register'), array('class' => 'btn btn-inverse signup-div')); ?>
                </div>



            </div>


        </div>
<?php $this->endWidget(); ?>


        <div class="col-md-6">
            <div class="heading-box"><h2><?php echo $data['welcome']['title']; ?></h2></div>
            <div><?php echo $data['welcome']['description']; ?></div>
        </div>
    </div>
</div>

<script type="text/javascript">

/*    function checkEmail(email) {
        jQuery.ajax({
            type: "POST",
            url: "<?php echo Yii::app()->baseUrl ?>/index.php/accounts/checkemail",
            data: "email=" + email,
            complete: function(data) {
                if (data.responseText == 1) {
                    jQuery("#Customer_email").val('');
                    jQuery("#status-msg").html("Already Exist");
                } else {
                    jQuery("#status-msg").html("ok");
                }
            }
        });
    }*/

</script>