<input type='hidden' value='4' id='count_div'>
<div class="row-fluid">
    <div class="tab-pane active" id="Information">
        <div class="span12 pull-left">
            <div class="span12">
                <fieldset class="portlet " >
                    <div class="portlet-decoration">
                        <div class="span11"><?php echo Yii::t('attributegroups','heading_sub_title');?> </div>
                        <div class="span1 Dev-arrow"><button class="btn btn-info arrow_main" id="hide_box_btn1" type="button"></button> </div>
                        <div class="clearfix"></div>	
                    </div>
                    <div class="portlet-content" id="hide_box_line1">
                        <?php
                        echo $form->textFieldRow(
                                $model['od'], 'name',
                                array('rel' => 'tooltip', 'title' => 'Group name displayed to the customer.Invalid characters <>;=#{}', 'data-toggle' => "tooltip",
                            'data-placement' => "right",)
                        );

                        echo $form->textFieldRow(
                                $model['o'], 'sort_order',
                                array('rel' => 'tooltip', 'title' => 'Sorting order for the attribute group', 'data-toggle' => "tooltip",
                            'data-placement' => "right",)
                        );

                        ?>


                    </div>

                    <div class="span12 pull-right" id="attribute">

                        <?php
                        $box = $this->beginWidget(
                                'bootstrap.widgets.TbBox',
                                array(
                            'title' => 'Add/Edit Attributes',
                            'htmlOptions' => array('class' => 'portlet-decoration	')
                                )
                        );
                        ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width: 60%" >Name</th>
                                    <th style="width: 20%">Sort Order</th>
                                    <th style="width: 20%">Action</th>
                                </tr>
                            </thead>

                            <?php
                            $row = 0;
                            foreach ($model['ov'] as $model):
                                ?>
                                <tbody id='row-<?php echo $row; ?>'>
                                    <tr >
                                <input type='hidden' name='attribute[<?php echo $row; ?>][id_attribute]' value="<?php echo $model->id_attribute; ?>">
                                <td style="width: 60%"><?php echo CHtml::textField('attribute[' . $row . '][name]',
                                        $model->name,
                                        array('width' => 100, 'maxlength' => 100)); //echo $form->textField($model,'name',array('size'=>80,'maxlength'=>128)); 
                                ?></td>
                                <td style="width: 20%"><?php echo CHtml::textField('attribute[' . $row . '][sort_order]',
                                        $model->attribute->sort_order,
                                        array('width' => 100, 'maxlength' => 100));
                                ?></td>
                                <td><a onclick="$('#row-<?php echo $row; ?>').remove()" class="btn btn-info" ><i class="delete-iconall"></i></a> </td>
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
                                            'label' => 'Add ',
                                            'type' => 'btn-info',
                                            'htmlOptions' => array('onclick' => 'addAttribute()'),
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
        function addAttribute()
        {
            row = '<tbody id="row-' + row_no + '">';
            row += '<tr>';
            row += '<input type="hidden" value="" name="attribute[' + row_no + '][id_attribute]">';
            row += '<td style="width: 60%"><input width="100" type="text" id="attribute_1_name" name="attribute[' + row_no + '][name]" value="" maxlength="100"></td>';
            row += '<td style="width: 20%"><input width="100" type="text" id="attribute_1_sort_order" name="attribute[' + row_no + '][sort_order]" value="" maxlength="100"></td>';
            row += '<td> <a onclick="$(\'#row-' + row_no + '\').remove();" href="#" class="btn btn-danger" ><i class="delete-iconall"></i></a> </td>';
            row += '</tr>';
            row += '</tbody>';
            $('.table tfoot').before(row);
            row_no++;
        }
    </script>