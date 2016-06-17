<fieldset class="portlet" >
    <?php if($model['p']->download_status)
         {
            $downloadClass='class="portlet-decoration arrow-minus"';
            $downloadStyle='';
         }else
         {
            $downloadClass='class="portlet-decoration"';
            $downloadStyle='style="display:none;"';
         }?>
    <div <?php echo $downloadClass?> onclick=" $('#hide_box_line8').slideToggle();">
        <div class="span11"><?php echo yii::t('products',
        'entry_downloadable_file'); ?> </div>
        <div class="span1 Dev-arrow"><button class="btn btn-info arrow_main" id="hide_box_btn8" type="button"></button> </div>
        <div class="clearfix"></div>	
    </div>
    <div class="portlet-content" id="hide_box_line8" <?php echo $downloadStyle;?>>
        <div class="span5">  <?php
            echo $form->dropDownListRow($model['p'], 'download_status',
                    array('0' => Yii::t('common', 'text_disabled'), '1' => Yii::t('common',
                        'text_enabled')));
            ?></div>

            <div class="span5 uploading-img-main"> <?php
                    echo $form->fileFieldRow(
                    $model['p'], 'download_filename',
                    array('name'=>'download_filename', 'rel'=>'tooltip','data-toggle'=>"tooltip",'data-placement'=>"right", 
                        'class'=>'Options_design'),
                    array('hint' => '<div id="image-name-display-id"><a href="'.$this->createUrl('product/download',
                    array('file'=>base64_encode($model['p']->download_filename))).'">'.$model['p']->download_filename.'</a><div>'
                        . '<input type="hidden" name="download_prev_file" value="'.$model['p']->download_filename.'"></div></div>')
                    )   ; ?>
            </div>
        <div class="span5">  <?php
            echo $form->textFieldRow(
                    $model['p'], 'download_allowed_count',
                    array(
                'rel' => 'tooltip', 'data-toggle' => "tooltip",
                'data-placement' => "right",
                    )
            );
            ?>
        </div>
        <div class="span5">  <?php
            echo $form->textFieldRow(
                    $model['p'], 'download_allowed_days',
                    array(
                'rel' => 'tooltip', 'data-toggle' => "tooltip",
                'data-placement' => "right",
                    )
            );
            ?>   
        </div>
    </div>
</fieldset>
<!--        end other block -->