<div class="row-fluid">
    <div class="tab-pane active" id="Information">
        <div class="span12 pull-left">
            <div class="span12">
                <fieldset class="portlet " >
                     <div class="portlet-decoration arrow-minus" onclick=" $('#hide_box_line1').slideToggle();">
                        <div class="span11">News Letter  </div>
                        <div class="span1 Dev-arrow"><button class="btn btn-info arrow_main" type="button"></button> </div>
                        <div class="clearfix"></div>	
                    </div>
                    <div class="portlet-content" id="hide_box_line1">
                        <?php
                  //      echo "Name : ".CHtml::textField('data[name]', $data['data']['name']);
                       // echo "Key : ".CHtml::textField('data[key]', $data['data']['key']);
                        ?>
                    

                    <div class="span12 pull-right" id="attribute">

                        <?php
                        $box = $this->beginWidget(
                                'bootstrap.widgets.TbBox',
                                array(
                            'title' => 'Add/Edit News Letter Module',
                            'htmlOptions' => array('class' => 'portlet-decoration	')
                                )
                        );
                        ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width: 22%"><?php echo  Yii::t('modules','entry_layout')?></th>
                                    <th style="width: 22%"><?php echo  Yii::t('modules','entry_position')?></th>
                                    <th style="width: 22%"><?php echo  Yii::t('modules','entry_sort_order')?></th>
                                    <th style="width: 22%"><?php echo  Yii::t('modules','entry_status')?></th>
                                    <th style="width: 8%"><?php echo  Yii::t('modules','entry_action')?></th>
                                </tr>
                            </thead>

                            <?php
                            $row = 0;
                            foreach ($data['module'] as $input):
                                ?>
                                <tbody id='row-<?php echo $row; ?>'>
                                    <tr >
                                        <td style="width: 20%">
                                            <?php echo CHtml::dropDownList('module[' . $row . '][layout]', $input['layout'],Library::getLayouts());
                                            //echo CHtml::textField('module[' . $row . '][layout]', $input['layout']); ?></td>
                                        <td style="width: 20%"><?php echo CHtml::dropDownList('module[' . $row . '][position]', $input['position'],Library::getPositions());
                                                    //echo CHtml::textField('module[' . $row . '][position]', $input['position']); ?></td>
                                        <td style="width: 20%"><?php echo CHtml::textField('module[' . $row . '][sort_order]', $input['sort_order']); ?></td>
                                        <td style="width: 20%"><?php 
echo CHtml::dropDownList('module[' . $row . '][status]', $input['status'],array("0"=>"Disable","1"=>"Enable"));
//echo CHtml::textField('module[' . $row . '][status]', $input['status']); ?></td>
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
                                            'label' => Yii::t('modules','entry_add_more'),
                                            'type' => 'btn-info',
                                            'htmlOptions' => array('onclick' => 'addModule()'),
                                                )
                                        );
                                        ?></td>
                                </tr>
                            </tfoot>
                        </table>
<?php $this->endWidget();                             
						?>
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