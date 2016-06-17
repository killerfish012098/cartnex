<fieldset class="portlet " >
    <div class="portlet-decoration arrow-minus" onclick=" $('#hide_box_line77').slideToggle();">
        <div class="span11"><?php echo yii::t('products',
        'entry_add_edit_image'); ?> </div>
        <div class="span1 Dev-arrow"><button class="btn btn-info arrow_main" id="hide_box_btn77" type="button"></button> </div>
        <div class="clearfix"></div>	
    </div>
    <div class="portlet-content" id="hide_box_line77">
        <table class="table" id="multiImage">
            <thead>
                <tr>
                    <th><?php echo Yii::t('products', 'entry_image'); ?></th>
                    <th><?php echo Yii::t('products', 'entry_sort_order'); ?></th>
                    <th><?php echo Yii::t('products', 'entry_action'); ?></th>
                </tr>
            </thead>
            <?php
            $row = 0;
            if (is_array($model['pi'])) {
                foreach ($model['pi'] as $pimage):?>
                    <tbody id='rowMultiImage-<?php echo $row; ?>'>
                        <tr >
                                <?php echo CHtml::activeHiddenField($pimage,
                                        'prev_image',
                                        array('name' => 'ProductImage[upload][' . $row . '][prev_image]',
                                    'value' => $pimage->image)); ?>
                            <td><?php /*echo CHtml::activeFileField($pimage, 'image',
                                array('name' => 'ProductImage[upload][' . $row . '][image]'));*/
                            /*echo $form->fileFieldRow(
				$pimage, 'image',
				array('name'=>'ProductImage[upload][' . $row . '][image]', 'rel'=>'tooltip','title'=>'Upload product image from your computer','data-toggle'=>"tooltip",'data-placement'=>"right", 
                                    'class'=>'Options_design'),
				array('hint' => '<div class="logo-img"><img src="'.Library::getCatalogUploadLink().$pimage->image.'" width="150px" height="150px">'
                                    . '<input type="hidden" name="prev_file" value="'.$pimage->image.'"></div>')
				);
				 echo '<p class="image-name-display">' .$pimage->image. '</p>';*/
                            ?>
                                
                                <div class="span5 uploading-img-main"> 
                                    <div class="control-group">
                                        <div class="controls">
                                            <input type="file" id="ProductImage[upload][<?php echo $row;?>][image]?>" class="Options_design" data-placement="right" data-toggle="tooltip" rel="tooltip"
                                                   name="ProductImage[upload][<?php echo $row;?>][image]" data-original-title="Upload category logo from your computer">
                                            <div style="display:none" id="ProductImage[upload][<?php echo $row;?>][image]" class="help-inline error"></div><p class="help-block"></p>
                                             <div  id="image-name-display-id"><?php echo $pimage->image;?>
                                            <div class="logo-img">
                                                <img   src="<?php echo Library::getCatalogUploadLink().$pimage->image;?>">
                                                <!--<input type="hidden" value="<?php echo $pimage->image;?>" name="prev_file">-->
                                            </div>
                                            </div>
                                          
                                        </div>
                                    </div>
                                   
                                </div>
                            </td>
                            <td><?php  echo CHtml::activeTextField($pimage, 'sort_order',
                                       array('name' => 'ProductImage[upload][' . $row . '][sort_order]'));?>
                            </td>
                            <td> <a onclick="$('#rowMultiImage-<?php echo $row; ?>').remove()" class="btn btn-danger"><i class="delete-iconall"></i></a> </td>
                        </tr>
                    </tbody>
                                <?php
                                $row++;
                            endforeach;
                        }
                        ?>
            <tfoot>
                <tr>
                    <td colspan="5"><?php
                        $this->widget(
                                'bootstrap.widgets.TbButton',
                                array(
                            'label' => 'Add ',
                            'type' => 'btn-info',
                            'htmlOptions' => array('onclick' => 'addImage()'),
                                )
                        );
                        ?></td>
                </tr>
            </tfoot>
        </table>
    </div></fieldset>
<script type='text/javascript'>
    var row_no =<?php echo $row; ?>;
    function addImage()
    {
        row = '<tbody id="rowMultiImage-' + row_no + '">';
        row += '<tr>';
        row += '<input type="hidden" value="" id="ProductImage_upload_' + row_no + '_prev_image" name="ProductImage[upload][' + row_no + '][prev_image]">';
        row += '<td><input id="ProductImage_upload_' + row_no + '_image" name="ProductImage[upload][' + row_no + '][image]" type="file">\n\
    <input id="ytproductimage_upload_' + row_no + '_image" type="hidden" name="ProductImage[upload][' + row_no + '][image]" value=""></td>';
        row += '<td><input id="ProductImage_upload_' + row_no + '_sort_order" name="ProductImage[upload][' + row_no + '][sort_order]" type="text"></td>';
        row += '<td> <a onclick="$(\'#rowMultiImage-' + row_no + '\').remove();" href="#" class="btn btn-danger"><i class="delete-iconall"></i></a> </td>';
        row += '</tr>';
        row += '</tbody>';
        $('#multiImage tfoot').before(row);
        row_no++;
    }

</script>