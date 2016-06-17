<div class="center-wrapper register-inner-pages"> 
    <div class="col-md-12">
        <div class="heading-box"><h2><?php echo Yii::t('account', 'heading_title_account'); ?></h2></div>
        <div>
            <div class="row ">
                <div class="col-md-6"> <?php
                    $box = $this->beginWidget(
                            'bootstrap.widgets.TbBox', array('title' => Yii::t('account', 'heading_contact_information'),
                        'headerButtons' => array(array('class' => 'bootstrap.widgets.TbButtonGroup',
                                'type' => '', 'buttons' => array(array('label' => '', 'htmlOptions' => array('class' => 'glyphicon glyphicon-pencil'),
                                        'url' => $this->createUrl('account/profile')),)),),));
                    ?>

                    <table class="table">
                        <?if(!empty($data['account']['firstname'])):?>
                        <tr>
                            <td><strong><?php echo Yii::t('account', 'entry_firstname'); ?></strong></td>
                            <td>:</td>
                            <td><?php echo $data['account']['firstname'] ?></td>
                        </tr>
<?php endif; ?>
                        <?if(!empty($data['account']['lastname'])):?>
                        <tr>
                            <td><strong><?php echo Yii::t('account', 'entry_lastname'); ?></strong></td>
                            <td>:</td>
                            <td><?php echo $data['account']['lastname'] ?></td>
                        </tr>
<?php endif ?>
                        <?if(!empty($data['account']['email'])):?>
                        <tr>
                            <td><strong><?php echo Yii::t('account', 'entry_email'); ?></strong></td>
                            <td>:</td>
                            <td><?php echo $data['account']['email'] ?></td>
                        </tr>
<?php endif ?>
                        <?if(!empty($data['account']['telephone'])):?>
                        <tr>
                            <td><strong><?php echo Yii::t('account', 'entry_telephone'); ?></strong></td>
                            <td>:</td>
                            <td><?php echo $data['account']['telephone'] ?></td>
                        </tr>
                    <?php endif ?>
                    </table>
<?php $this->endWidget(); ?>
                </div>




                <div class="col-md-6">
                    <?php $box = $this->beginWidget('bootstrap.widgets.TbBox', array('title' => Yii::t('account', 'heading_address_book'), 'headerButtons' => array(array('class' => 'bootstrap.widgets.TbButtonGroup', 'type' => 'info', 'buttons' => array(array('label' => '', 'htmlOptions' => array('class' => 'glyphicon glyphicon-pencil'), 'url' => $this->createUrl('account/address')),)),),)); ?> 
                     <table class="table">
                        <?if(!empty($data['account']['address_firstname'])):?>
                        <tr>
                            <td><strong><?php echo Yii::t('account', 'entry_firstname'); ?></strong></td>
                            <td>:</td>
                            <td><?php echo $data['account']['address_firstname'] ?></td>
                        </tr>
<?php endif; ?>
                        <?if(!empty($data['account']['address_lastname'])):?>
                        <tr>
                            <td><strong><?php echo Yii::t('account', 'entry_lastname'); ?></strong></td>
                            <td>:</td>
                            <td><?php echo $data['account']['address_lastname'] ?></td>
                        </tr>
<?php endif ?>
                        <?if(!empty($data['account']['address_telephone'])):?>
                        <tr>
                            <td><strong><?php echo Yii::t('account', 'entry_telephone'); ?></strong></td>
                            <td>:</td>
                            <td><?php echo $data['account']['address_telephone'] ?></td>
                        </tr>
<?php endif ?>
                        <?if(!empty($data['account']['address_company'])):?>
                        <tr>
                            <td><strong><?php echo Yii::t('account', 'entry_company'); ?></strong></td>
                            <td>:</td>
                            <td><?php echo $data['account']['address_company'] ?></td>
                        </tr>
                    <?php endif ?>

					<?if(!empty($data['account']['address_1'])):?>
                        <tr>
                            <td><strong><?php echo Yii::t('account', 'entry_address1'); ?></strong></td>
                            <td>:</td>
                            <td><?php echo $data['account']['address_1'] ?></td>
                        </tr>
                    <?php endif ?>

                    <?if(!empty($data['account']['address_2'])):?>
                        <tr>
                            <td><strong><?php echo Yii::t('account', 'entry_address2'); ?></strong></td>
                            <td>:</td>
                            <td><?php echo $data['account']['address_2'] ?></td>
                        </tr>
                    <?php endif ?>

					<?if(!empty($data['account']['address_city'])):?>
                        <tr>
                            <td><strong><?php echo Yii::t('account', 'entry_city'); ?></strong></td>
                            <td>:</td>
                            <td><?php echo $data['account']['address_city'] ?></td>
                        </tr>
                    <?php endif ?>

					<?if(!empty($data['account']['state'])):?>
                        <tr>
                            <td><strong><?php echo Yii::t('account', 'entry_state'); ?></strong></td>
                            <td>:</td>
                            <td><?php echo $data['account']['state'] ?></td>
                        </tr>
                    <?php endif ?>

					<?if(!empty($data['account']['address_postcode'])):?>
                        <tr>
                            <td><strong><?php echo Yii::t('account', 'entry_postcode'); ?></strong></td>
                            <td>:</td>
                            <td><?php echo $data['account']['address_postcode'] ?></td>
                        </tr>
                    <?php endif ?>

					<?if(!empty($data['account']['country'])):?>
                        <tr>
                            <td><strong><?php echo Yii::t('account', 'entry_country'); ?></strong></td>
                            <td>:</td>
                            <td><?php echo $data['account']['country'] ?></td>
                        </tr>
                    <?php endif ?>

                    </table>
<?php $this->endWidget(); ?>
                </div>
                <div class="col-md-12"> 
<?php $box = $this->beginWidget('bootstrap.widgets.TbBox', array('title' => Yii::t('account', 'heading_newsletter'), 'headerButtons' => array(array('class' => 'bootstrap.widgets.TbButtonGroup', 'type' => 'info', 'buttons' => array(array('label' => '', 'htmlOptions' => array('class' => 'glyphicon glyphicon-pencil'), 'url' => $this->createUrl('account/profile')),),),),)); ?>
                    <p><?php echo $data['text_newsletter_subscribe']; ?></p>
<?php $this->endWidget(); ?>
                </div>
            </div>
        </div>
    </div>
</div>