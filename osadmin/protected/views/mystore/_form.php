<?php //echo '<pre>';print_r($model);echo '</pre>';
//echo "valu eof ".$model->CONFIG_STORE_ALLOW_CHECKOUT;
?>

<div class="row-fluid">
    <div class="tab-pane active" id="Information">
        <div class="span1['pd']">
            <fieldset class="portlet" >
                <div class="portlet-decoration arrow-minus" onclick=" $('#hide_box_line1').slideToggle();">
                    <div class="span11">General </div>
                    <div class="span1 Dev-arrow"><button class="btn btn-info arrow_main" type="button"></button>   </div>				 <div class="clearfix"></div>	
                </div>
                <div class="portlet-content design_main_form" id="hide_box_line1">


                    
                    <div class="span5">
                        <?php
                        echo $form->textFieldRow($model, 'CONFIG_STORE_NAME',
                                array(
                            'rel' => 'tooltip',  'data-toggle' => "tooltip",
                            'data-placement' => "right",));
                        ?>
                    </div>

					                    <div class="span5 uploading-img-main"> <?php
                        echo $form->fileFieldRow(
                                $model, 'CONFIG_STORE_LOGO_IMAGE',
                                array('name' => 'CONFIG_STORE_LOGO_IMAGE', 'rel' => 'tooltip', 
                            'data-toggle' => "tooltip", 'data-placement' => "right",
                            'class' => 'Options_design'),
                                array('hint' => '<div id="image-name-display-id"> '. $model->CONFIG_STORE_LOGO_IMAGE .' <div class="logo-img"><img src="' . Library::getMiscUploadLink() . $model->CONFIG_STORE_LOGO_IMAGE . '">'
                                    . '<input type="hidden" name="CONFIG_STORE_LOGO_IMAGE" value="' . $model->CONFIG_STORE_LOGO_IMAGE . '"></div></div>')
                        );
                        
                        ?>
                    </div>

					                    <div class="span5 uploading-img-main"> <?php
                        echo $form->fileFieldRow(
                                $model, 'CONFIG_STORE_NO_IMAGE',
                                array('name' => 'CONFIG_STORE_NO_IMAGE', 'rel' => 'tooltip', 
                            'data-toggle' => "tooltip", 'data-placement' => "right",
                            'class' => 'Options_design'),
                                array('hint' => '<div id="image-name-display-id"> '. $model->CONFIG_STORE_NO_IMAGE .' <div class="logo-img"><img src="' . Library::getMiscUploadLink() . $model->CONFIG_STORE_NO_IMAGE . '">'
                                    . '<input type="hidden" name="CONFIG_STORE_NO_IMAGE" value="' . $model->CONFIG_STORE_NO_IMAGE . '"></div></div>')
                        );
                        //echo '<p class="image-name-display">' . $model->CONFIG_STORE_NO_IMAGE . '</p>';
                        ?>
                    </div>
                    

                    
                    <div class="span5 uploading-img-main"> <?php
                        echo $form->fileFieldRow(
                                $model, 'CONFIG_STORE_FAVI_IMAGE',
                                array('name' => 'CONFIG_STORE_FAVI_IMAGE', 'rel' => 'tooltip', 
                            'data-toggle' => "tooltip", 'data-placement' => "right",
                            'class' => 'Options_design'),
                                array('hint' => '<div id="image-name-display-id"> '. $model->CONFIG_STORE_FAVI_IMAGE .' <div class="logo-img"><img src="' . Library::getMiscUploadLink() . $model->CONFIG_STORE_FAVI_IMAGE . '">'
                                    . '<input type="hidden" name="CONFIG_STORE_FAVI_IMAGE" value="' . $model->CONFIG_STORE_FAVI_IMAGE . '"></div></div>')
                        );
                        //echo '<p class="image-name-display">' . $model->CONFIG_STORE_FAVI_IMAGE . '</p>';
                        ?>
                    </div>
                    <div class="span5">
                        <?php
                        echo $form->textFieldRow($model, 'CONFIG_STORE_OWNER',
                                array(
                            'rel' => 'tooltip','data-toggle' => "tooltip",
                            'data-placement' => "right",));
                        ?>
                    </div>
                    <div class="span5">
                        <?php
                        echo $form->textFieldRow($model,
                                'CONFIG_STORE_OWNER_EMAIL_ADDRESS',
                                array(
                            'rel' => 'tooltip','data-toggle' => "tooltip",
                            'data-placement' => "right",));
                        ?>
                    </div>
                    <div class="span5">
                        <?php
                        echo $form->textFieldRow($model,
                                'CONFIG_STORE_SUPPORT_EMAIL_ADDRESS',
                                array(
                            'rel' => 'tooltip',  'data-toggle' => "tooltip",
                            'data-placement' => "right",
                                )
                        );
                        ?>
                    </div>
                    
                    <div class="span5">
                        <?php
                        echo $form->textFieldRow($model,
                                'CONFIG_STORE_REPLY_EMAIL',
                                array(
                            'rel' => 'tooltip',  'data-toggle' => "tooltip",
                            'data-placement' => "right",
                                )
                        );
                        ?>
                    </div>
                    
                    
                    <div class="span5">
                        <?php
                        echo $form->textFieldRow($model,
                                'CONFIG_STORE_TELEPHONE_NUMBER',
                                array(
                            'rel' => 'tooltip', 'data-toggle' => "tooltip",
                            'data-placement' => "right",
                                )
                        );
                        ?>
                    </div>
                    <div class="span5">
                        <?php
                        echo $form->textFieldRow($model,
                                'CONFIG_STORE_FAX_NUMBER',
                                array(
                            'rel' => 'tooltip', 'data-toggle' => "tooltip",
                            'data-placement' => "right",
                                )
                        );
                        ?>
                    </div>
                    <div class="span5">
                        <?php
                        echo $form->textAreaRow($model, 'CONFIG_STORE_ADDRESS',
                                array(
                            'rel' => 'tooltip',  'data-toggle' => "tooltip",
                            'data-placement' => "right",
                                )
                        );
                        ?>
                    </div>
					<div class="span5">
                        <?php
                        echo $form->dropDownListRow($model,
                                'CONFIG_STORE_STATE',
                                CHtml::listData($data['states'], 'id_state',
                                        'name'));
                        ?>
                    </div>
                    <div class="span5">
                        <?php
                        echo $form->dropDownListRow($model,
                                'CONFIG_STORE_COUNTRY',
                                CHtml::listData(Country::getCountries(),
                                        'id_country', 'name'));
                        ?>
                    </div>
                    <div class="span5">
                        <?php
                        echo $form->radioButtonListRow($model,
                                'CONFIG_STORE_ALLOW_CHECKOUT',
                                array(
                            '1' => Yii::t('common', 'text_yes'),
                            '0' => Yii::t('common', 'text_no'),
                                )
                        );
                        ?>
                    </div>
                    <div class="span5">
                        <?php
                        echo $form->radioButtonListRow($model,
                                'CONFIG_STORE_LOGIN_SHOW_PRICE',
                                array(
                            '1' => Yii::t('common', 'text_yes'),
                            '0' => Yii::t('common', 'text_no'),
                                )
                        );
                        ?>
                    </div>
                    <div class="span5">
                        <?php
                        echo $form->radioButtonListRow($model,
                                'CONFIG_STORE_SHOW_CATEGORY_PRODUCT_COUNT',
                                array(
                            '1' => Yii::t('common', 'text_yes'),
                            '0' => Yii::t('common', 'text_no'),
                                )
                        );
                        ?>
                    </div>
                    <div class="span5">
                        <?php
                        echo $form->textFieldRow($model,
                                'CONFIG_STORE_INVOICE_PREFIX',
                                array(
                            'rel' => 'tooltip',  'data-toggle' => "tooltip",
                            'data-placement' => "right",
                                )
                        );
                        ?> 
                    </div>
                    <div class="span5">
                        <?php
                        echo $form->radioButtonListRow($model,
                                'CONFIG_STORE_APPROVE_NEW_CUSTOMER',
                                array(
                            '1' => Yii::t('common', 'text_yes'),
                            '0' => Yii::t('common', 'text_no'),
                                )
                        );
                        ?> 
                    </div>
                    <div class="span5">
                        <?php
                        echo $form->radioButtonListRow($model,
                                'CONFIG_STORE_ALLOW_GUEST_CHECKOUT',
                                array(
                            '1' => Yii::t('common', 'text_yes'),
                            '0' => Yii::t('common', 'text_no'),
                                )
                        );
                        ?>
                    </div>
                    <div class="span5">
                        <?php
                        echo $form->radioButtonListRow($model,
                                'CONFIG_STORE_ALLOW_REVIEWS',
                                array(
                            '1' => Yii::t('common', 'text_yes'),
                            '0' => Yii::t('common', 'text_no'),
                                )
                        );
                        ?>
                    </div>
                    <div class="span5">
                        <?php
                        /*echo $form->textFieldRow($model,
                                'CONFIG_STORE_ACCOUNT_TERMS',
                                array(
                            'rel' => 'tooltip','data-toggle' => "tooltip",
                            'data-placement' => "right",
                                )
                        );*/
						
						echo $form->dropDownListRow($model,'CONFIG_STORE_ACCOUNT_TERMS',$data['pages']);

                        ?>
                    </div>
                    <div class="span5">
                        <?php echo $form->dropDownListRow($model,'CONFIG_STORE_CHECKOUT_TERMS',$data['pages']);?>
                    </div>
  
                    <div class="span5">
<?php
echo $form->textAreaRow($model, 'CONFIG_STORE_ORDER_ALERT_MAILS',
        array(
    'rel' => 'tooltip','data-toggle' => "tooltip",
    'data-placement' => "right",
        )
);
?>
                    </div>

                </div>
            </fieldset>
        </div>  
    </div>
</div>

<script type="text/javascript"><!--
$('select[id=\'MystoreForm_CONFIG_STORE_COUNTRY\']').bind('change', function() {
        $.ajax({
            url: '<?php echo $this->createUrl("site/getStates")?>/' + this.value,
            dataType: 'json',
            success: function(json) {
                var html;
                if (json['states'] != '') {
                    for (i = 0; i < json['states'].length; i++) {
                        html += '<option value="' + json['states'][i]['id_state'] + '"';

                        if (json['states'][i]['id_states'] == '<?php echo $model->CONFIG_STORE_STATE; ?>') {
                            html += ' selected="selected"';
                        }

                        html += '>' + json['states'][i]['name'] + '</option>';
                    }
                } else {
                    html += '<option value="" selected="selected"><?php echo Yii::t("common",
        "text_none");
?></option>';
                }

                $('select[id=\'MystoreForm_CONFIG_STORE_STATE\']').html(html);
            }
        });
    });

//--></script> 
