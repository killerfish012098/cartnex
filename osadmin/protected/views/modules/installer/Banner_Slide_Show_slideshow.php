<div class="row-fluid">
    <div class="tab-pane active" id="Information">
        <div class="span12 pull-left">
            <div class="span12">
                <fieldset class="portlet " >
                     <div class="portlet-decoration arrow-minus" onclick=" $('#hide_box_line1').slideToggle();">
                        <div class="span11"><?php echo Yii::t('modules','heading_title_slideshow')?></div>
                        <div class="span1 Dev-arrow"><button class="btn btn-info arrow_main" type="button"></button> </div>
                        <div class="clearfix"></div>	
                    </div>
                    <div class="portlet-content" id="hide_box_line1">
                        <?php
						// echo "Name : ".CHtml::textField('data[name]', $data['data']['name']);
                        // echo "Key : ".CHtml::textField('data[key]', $data['data']['key']);
                        ?>
                 
                    <div class="span12 pull-right" id="attribute">

                         
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width: 20%"><?php echo  Yii::t('modules','entry_banner')?></th>
                                    <th style="width: 20%"><?php echo  Yii::t('modules','entry_image')?></th>
                                    <th style="width: 20%"><?php echo  Yii::t('modules','entry_layout')?></th>
                                    <th style="width: 20%"><?php echo  Yii::t('modules','entry_position')?></th>
                                    <th style="width: 10%"><?php echo  Yii::t('modules','entry_sort_order')?></th>
                                    <th style="width: 10%"><?php echo  Yii::t('modules','entry_status')?></th>
                                    <th style="width: 20%"><?php echo  Yii::t('modules','entry_action')?></th>
									
                                </tr>
                            </thead>

                            <?php
                            $row = 0;
                            $list=CHtml::listData(Banner::getBanners(),'id_banner','name');
                            foreach ($data['module'] as $input):
                                ?>
                                <tbody id='row-<?php echo $row; ?>'>
                                    <tr >
									
					<td ><?php echo CHtml::dropDownList('module[' . $row . '][banner]', $input['banner'],$list);?></td>
					<td><?php echo CHtml::textField('module[' . $row . '][height]', $input['height'], array('class'=>'span5')); ?>
					<?php echo CHtml::textField('module[' . $row . '][width]', $input['width'], array('class'=>'span5')); ?></td>
                                        <td><?php echo CHtml::dropDownList('module[' . $row . '][layout]', $input['layout'],Library::getLayouts());?></td>
                                        <td ><?php echo CHtml::dropDownList('module[' . $row . '][position]', $input['position'],Library::getPositions()); ?></td>
                                        <td><?php echo CHtml::textField('module[' . $row . '][sort_order]', $input['sort_order']); ?></td>
                                        <td><?php	echo CHtml::dropDownList('module[' . $row . '][status]', $input['status'],array("0"=>"Disable","1"=>"Enable")); ?></td>
                                        <td><a onclick="$('#row-<?php echo $row; ?>').remove()" class="btn btn-danger" ><i class="delete-iconall"></i></a> </td>
                                    </tr>
                                </tbody>
                                <?php
                                $row++;
                            endforeach;
                            

                            ?>


                            <tfoot>
                                <tr>
                                    <td colspan="7"><?php
                                        $this->widget(
                                                'bootstrap.widgets.TbButton',
                                                array(
                                            'label' => Yii::t('modules','entry_add_more'),
                                            'type' => 'btn-info',
                                            'htmlOptions' => array('onclick' => 'addModule()'),
                                                )
                                        );
                                        ?></td>
                                </tr>
                            </tfoot>
                        </table>
                     </div>
                  </div>
                </fieldset>

            </div>   

        </div>
    </div>
    <script type='text/javascript'>
        var row_no =<?php echo $row; ?>;
        function addModule()
        {
            row = '<tbody id="row-' + row_no + '">';
            row += '<tr>';
            row += '<td><select name="module[' + row_no + '][banner]"><?php foreach($list as $k=>$v){ echo '<option value="'.$k.'">'.$v.'</option>';}?></select></td>';
			//row += '<td><input  type="text" name="module[' + row_no + '][banner]" value="" maxlength="100"></td>';
			row += '<td class="width-hight-online-line"><input  type="text" name="module[' + row_no + '][height]" value="" maxlength="100" class="span5"><input  type="text" name="module[' + row_no + '][width]" value="" maxlength="100" class="span5"></td>';
			row += '<td><select name="module[' + row_no + '][layout]"><?php foreach(Library::getLayouts() as $k=>$v){ echo '<option value="'.$k.'">'.$v.'</option>';}?></select></td>';
            row += '<td><select name="module[' + row_no + '][position]"><?php foreach(Library::getPositions() as $k=>$v){ echo '<option value="'.$k.'">'.$v.'</option>';}?></select></td>';
            row += '<td><input  type="text" name="module[' + row_no + '][sort_order]" value="" maxlength="100"></td>';
            row += '<td><select name="module[' + row_no + '][status]"><?php echo '<option value="1">Enable</option><option value="0">Disable</option>';?></select></td>';
            row += '<td> <a onclick="$(\'#row-' + row_no + '\').remove();" href="#" class="btn btn-danger" ><i class="delete-iconall"></i></a> </td>';
            row += '</tr>';
            row += '</tbody>';
            $('.table tfoot').before(row);
            row_no++;
        }
    </script>
</div>