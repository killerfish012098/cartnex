<div class="row-fluid">
    <div class="tab-pane active" id="Information">
        <div class="span12">
            <fieldset class="portlet" >
                <div class="portlet-decoration arrow-minus" onclick=" $('#hide_box_line1').slideToggle();">
                    <div class="span11"><?php echo Yii::t('banners',
        'heading_sub_title'); ?> </div>
                    <div class="span1 Dev-arrow"><button class="btn btn-info arrow_main" type="button"></button> </div>
                    <div class="clearfix"></div>	
                </div>
                <div class="portlet-content" id="hide_box_line1">
                    <div class="span8"> <?php
                        echo $form->textFieldRow(
                                $model['b'], 'name',
                                array('rel' => 'tooltip', 
                            'data-toggle' => "tooltip",
                            'data-placement' => "right",)
                        );
                        ?>
                    </div>
                    <div class="span6"> 
<?php echo $form->radioButtonListRow($model['b'], 'status',
        array('1' => 'Enable', '0' => 'Disable')); ?>
                    </div>


                </div>

                <div class="span12 pull-right" id="banner_image">

                    <?php
                    $box = $this->beginWidget(
                            'bootstrap.widgets.TbBox',
                            array(
                        'title' => Yii::t('banners', 'entry_banner_images'),
                        'htmlOptions' => array('class' => 'portlet-decoration	')
                            )
                    );
                    ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 30%" ><?php echo Library::flag() . Yii::t('banners',
                            'entry_title'); ?></th>
                                <th style="width: 30%"><?php echo Yii::t('banners',
                            'entry_link'); ?></th>
                                <th style="width: 30%"><?php echo Yii::t('banners',
                                'entry_image'); ?></th>
                                <th style="width: 10%"><?php echo Yii::t('banners',
                                'entry_action'); ?></th>
                            </tr>
                        </thead>

                            <?php
                            $row = 0;
                            foreach ($model['bi'] as $model):
                                ?>
                            <tbody id='row-<?php echo $row; ?>'>
                                <tr >
                            <input type='hidden' name='banner_image[<?php echo $row; ?>][id_banner_image]' value="<?php echo $model->id_banner_image; ?>">
                            <td><?php
                            echo CHtml::textField('banner_image[' . $row . '][title]',
                                    $model->title,
                                    array('width' => 100, 'maxlength' => 100));
                                ?></td>
                            <td ><?php
                            echo CHtml::textField('banner_image[' . $row . '][link]',
                                    $model->bannerimage->link,
                                    array('width' => 100, 'maxlength' => 100));
                            ?></td>
                            <td >
                                <div class="span5 uploading-img-main"> 
                                    <div class="control-group">
                                        <div class="controls">
                                            <input type="file" id="banner_image[<?php echo $row;?>][image]?>" class="Options_design" 
                                                   data-placement="right" data-toggle="tooltip" rel="tooltip"
                                                   name="banner_image[<?php echo $row;?>][image]" data-original-title="Upload category logo 
                                                   from your computer">
                                            <div style="display:none" id="banner_image[<?php echo $row;?>][image]" class="help-inline error"></div>
                                            <p class="help-block"></p>
                                             <div  id="image-name-display-id"><?php echo $model->bannerimage->image;?>
                                            <div class="logo-img">
                                                <img   src="<?php echo Library::getMiscUploadLink().$model->bannerimage->image;?>">
                                    <input type="hidden" value="<?php echo $model->bannerimage->image;?>" name="banner_image[<?php echo $row;?>][prev_image]">
                                            </div>
                                            </div>
                                          
                                        </div>
                                    </div>
                                   
                                </div>
                                <?php
                            
                            
                            /*echo CHtml::textField('banner_image[' . $row . '][image]',
                                    $model->bannerimage->image,
                                    array('width' => 100, 'maxlength' => 100));*/
                            ?></td>
                            <td><a onclick="$('#row-<?php echo $row; ?>').remove()" class="btn btn-danger" ><i class="delete-iconall"></i></a> </td>
                            </tr>
                            </tbody>
                                        <?php
                                        $row++;
                                    endforeach;
                                    ?>


                        <tfoot>
                            <tr>
                                <td colspan="5"><?php
                                    $this->widget(
                                            'bootstrap.widgets.TbButton',
                                            array(
                                        'label' => Yii::t('banners',
                                                'entry_add_lable'),
                                        'type' => 'btn-info',
                                        'htmlOptions' => array('onclick' => 'addBannerImage()'),
                                            )
                                    );
                                    ?></td>
                            </tr>
                        </tfoot>
                    </table>
<?php $this->endWidget(); ?>
                </div>
            </fieldset>

        </div>   
    </div>
</div>
<script type='text/javascript'>
    var row_no =<?php echo $row; ?>;
    function addBannerImage()
    {
        row = '<tbody id="row-' + row_no + '">';
        row += '<tr>';
        row += '<input type="hidden" value="" name="banner_image[' + row_no + '][id_banner_image]">';
        row += '<td ><input width="100" type="text" id="banner_image_' + row_no + '_title" name="banner_image[' + row_no + '][title]" value="" maxlength="100"></td>';
        row += '<td><input width="100" type="text" id="banner_image_' + row_no + '_link" name="banner_image[' + row_no + '][link]" value="" maxlength="100"></td>';
        row += '<td><input type="file" data-original-title="Upload image" name="banner_image[' + row_no + '][image]"  /><input type="hidden" value="" name="banner_image[' + row_no + '][prev_image]"></td>';
        row += '<td><a onclick="$(\'#row-' + row_no + '\').remove();" class="btn btn-danger" ><i class="delete-iconall"></i></a> </td>';
        row += '</tr>';
        row += '</tbody>';
        $('.table tfoot').before(row);
        row_no++;
    }
</script>